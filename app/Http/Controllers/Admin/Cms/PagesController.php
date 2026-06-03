<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Pages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\PageRequest;
use App\Models\PageFeature;
use App\Models\PageContent;

class PagesController extends Controller
{

    public function index()
    {
        $query = Pages::query()->with('trans')->orderBy('id', 'DESC');
        if (request()->input('title')  != '') {
            $query = $query->WhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.cms.pages.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.cms.pages.create');
    }


    public function store(PageRequest $request)
    {
        $data = $request->getSanitized();

        $features = $data['features'] ?? [];
        $contents = $data['contents'] ?? [];

        unset($data['features'], $data['contents']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), 'pages');
        }

        $page = Pages::create($data);

        $this->saveFeatures($request, $page, $features);

        $this->saveContents($page, $contents);

        session()->flash('success', trans('message.admin.created_sucessfully'));

        if (request()->submit == "new") {
            return redirect()->back();
        }

        return redirect()->route('admin.pages.index');
    }


    public function show(Pages $page)
    {
        return view('admin.dashboard.cms.pages.show', compact('page'));
    }


    public function edit(Pages $page)
    {
        $page->load('features.trans', 'contents.trans');

        return view('admin.dashboard.cms.pages.edit', compact('page'));
    }


    public function update(PageRequest $request, Pages $page)
    {
        $data = $request->getSanitized();

        $features = $data['features'] ?? [];
        $contents = $data['contents'] ?? [];

        unset($data['features'], $data['contents']);

        if ($request->hasFile('image')) {
            $this->delete_file($page->image);
            $data['image'] = $this->upload_file($request->file('image'), 'pages');
        }

        $page->update($data);

        $this->saveFeatures($request, $page, $features);
        $this->saveContents($page, $contents);

        session()->flash('success', trans('message.admin.updated_sucessfully'));

        if (request()->submit == "update") {
            return redirect()->back();
        }

        return redirect()->route('admin.pages.index');
    }
    private function saveFeatures(PageRequest $request, Pages $page, array $features): void
    {
        $oldFeatureIds = $page->features()->pluck('id')->toArray();
        $savedFeatureIds = [];

        foreach ($features as $index => $featureData) {
            $hasContent = false;

            foreach (config('translatable.locales') as $locale) {
                if (
                    !empty($featureData[$locale]['title']) ||
                    !empty($featureData[$locale]['description'])
                ) {
                    $hasContent = true;
                    break;
                }
            }

            if (
                !$hasContent &&
                empty($featureData['url']) &&
                !$request->hasFile("features.$index.image") &&
                empty($featureData['old_image'])
            ) {
                continue;
            }

            $feature = null;

            if (!empty($featureData['id'])) {
                $feature = PageFeature::where('page_id', $page->id)
                    ->where('id', $featureData['id'])
                    ->first();
            }

            if (!$feature) {
                $feature = new PageFeature();
                $feature->page_id = $page->id;
            }

            $feature->url = $featureData['url'] ?? null;
            $feature->sort = $featureData['sort'] ?? $index;

            if ($request->hasFile("features.$index.image")) {
                if (!empty($feature->image)) {
                    $this->delete_file($feature->image);
                }

                $feature->image = $this->upload_file(
                    $request->file("features.$index.image"),
                    'pages/features'
                );
            } elseif (!empty($featureData['old_image'])) {
                $feature->image = $featureData['old_image'];
            }

            $feature->save();

            foreach (config('translatable.locales') as $locale) {
                $feature->translateOrNew($locale)->title =
                    $featureData[$locale]['title'] ?? null;

                $feature->translateOrNew($locale)->description =
                    $featureData[$locale]['description'] ?? null;
            }

            $feature->save();

            $savedFeatureIds[] = $feature->id;
        }

        $featuresToDelete = array_diff($oldFeatureIds, $savedFeatureIds);

        if (!empty($featuresToDelete)) {
            $deletedFeatures = PageFeature::whereIn('id', $featuresToDelete)->get();

            foreach ($deletedFeatures as $deletedFeature) {
                if (!empty($deletedFeature->image)) {
                    $this->delete_file($deletedFeature->image);
                }

                $deletedFeature->delete();
            }
        }
    }
    private function saveContents(Pages $page, array $contents): void
    {
        $oldContentIds = $page->contents()->pluck('id')->toArray();
        $savedContentIds = [];

        foreach ($contents as $index => $contentData) {
            $hasContent = false;

            foreach (config('translatable.locales') as $locale) {
                if (
                    !empty($contentData[$locale]['title']) ||
                    !empty($contentData[$locale]['description'])
                ) {
                    $hasContent = true;
                    break;
                }
            }

            if (!$hasContent) {
                continue;
            }

            $content = null;

            if (!empty($contentData['id'])) {
                $content = PageContent::where('page_id', $page->id)
                    ->where('id', $contentData['id'])
                    ->first();
            }

            if (!$content) {
                $content = new PageContent();
                $content->page_id = $page->id;
            }

            $content->sort = $contentData['sort'] ?? $index;
            $content->save();

            foreach (config('translatable.locales') as $locale) {
                $content->translateOrNew($locale)->title =
                    $contentData[$locale]['title'] ?? null;

                $content->translateOrNew($locale)->description =
                    $contentData[$locale]['description'] ?? null;
            }

            $content->save();

            $savedContentIds[] = $content->id;
        }

        $contentsToDelete = array_diff($oldContentIds, $savedContentIds);

        if (!empty($contentsToDelete)) {
            PageContent::whereIn('id', $contentsToDelete)->delete();
        }
    }
    public function destroy(Pages $page)
    {
        $page->load('features');

        foreach ($page->features as $feature) {
            $this->delete_file($feature->image);
        }

        $this->delete_file($page->image);
        $page->delete();

        session()->flash('success', trans('message.admin.deleted_sucessfully'));

        return redirect()->back();
    }


    public function update_status($id)
    {
        $page = Pages::findOrfail($id);
        $page->status == 1 ? $page->status = 0 : $page->status = 1;
        $page->save();
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $pages = Pages::findMany($request['record']);
            foreach ($pages as $page) {
                $page->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $pages = Pages::findMany($request['record']);
            foreach ($pages as $page) {
                $page->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $pages = Pages::findMany($request['record']);
            foreach ($pages as $page) {
                $this->delete_file($page->image);
                $page->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
