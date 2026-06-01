<div>
    <div class="row projects-body g-3">
        <!-- PROJECT CLUSTERS (start) -->
        @forelse ($projectCarousels as $key => $carousel)
            <div class="projects-body {{  $key % 2 == 0? 'wow bounceInLeft' : ' wow bounceInRight' }}">
                <div class="">
                    <div class="row">
                        @forelse ($carousel as $key => $project)
                        <livewire:site.home.project :project="$project" :wire:key="$project['id']" />
                        @empty
                        <h2 class="text-secondary text-center py-5 d-none">@lang('No projects available')</h2>
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <h2 class="text-secondary text-center py-5"> @lang('No_projects_available') </h2>
        @endforelse
        <!-- PROJECT CLUSTERS (end) -->
    </div>
    
    @if ($projectsCount - (count($projectCarousels) * 3) > 0)
        <div class="text-center my-4" wire:click="loadProjects">
            <a class="projects-more text-decoration-none" role="button"> @lang('More') </a>
        </div>
    @endif
</div>
