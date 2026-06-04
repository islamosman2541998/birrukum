<?php

namespace App\Http\Livewire\Site\Home;

use Livewire\Component;
use App\Models\CategoryProjects;
use App\Models\CharityProject;

class SubCategories extends Component
{
    protected $listeners = ['changeSelection'];

    public $selectedCategory = "", $subcategories, $firstCategory;

    public $selectedSubcategory = 0, $SelectedsubcategoriesIDs; 

    public $projectCarousels = [];
    public $projectsCount;

    public $projectsPerLoad = 6; // عدد المشاريع اللي تظهر أول مرة ومع كل ضغطة المزيد

    public function changeSelection($val)
    {
        $this->selectedCategory = $this->firstCategory = $val;
        $this->updateSubCategory();
    }

    public function selectSubcategory($selectedCategory)
    {
        if ($selectedCategory == 0) {
            $this->selectedSubcategory = 0;
            $this->updateSubCategory(); 
        } else {
            $this->SelectedsubcategoriesIDs = [$this->selectedSubcategory = $selectedCategory]; 
        }

        $this->projectCarousels = [];
        $this->updateProjects();
    }

    public function updateSubCategory()
    {
        $this->subcategories = CategoryProjects::active()
            ->feature()
            ->where('parent_id', $this->selectedCategory)
            ->with(['trans' => function ($query) {
                $query->where('locale', app()->getLocale());
            }])
            ->get();

        if ($this->subcategories->count() != 0) {
            $this->SelectedsubcategoriesIDs = $this->subcategories->pluck('id')->toArray();
        } else {
            $this->SelectedsubcategoriesIDs = [
                $this->selectedSubcategory == 0 ? $this->firstCategory : $this->selectedSubcategory
            ];
        }

        $this->projectCarousels = [];
        $this->updateProjects();
    }

    public function updateProjects($carouselIndex = 0)
    {
        $query = CharityProject::status(1)
            ->featuer(1)
            ->Web()
            ->orderBy('sort', 'ASC')
            ->with(['categories', 'trans' => function ($query) {
                $query->where('locale', app()->getLocale());
            }])
            ->whereHas('categories', function ($q) {
                $q->whereIn('category_id', $this->SelectedsubcategoriesIDs);
            });

        $this->projectsCount = $query->count();

        $this->projectCarousels[$carouselIndex] = $query
            ->offset($carouselIndex * $this->projectsPerLoad)
            ->limit($this->projectsPerLoad)
            ->get()
            ->toArray();
    }

    public function loadProjects()
    {
        $this->updateProjects(count($this->projectCarousels));
    }

    public function mount()
    {
        $this->selectedCategory = $this->firstCategory;
        $this->updateSubCategory();
    }

    public function render()
    {
        return view('livewire.site.home.sub-categories');
    }
}