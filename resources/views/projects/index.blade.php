@extends('layouts.app')

@section('content')
    <div class="container">

        <div>
            <div class="mx-auto max-w-2xl px-4 py-4 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Your Projects</h2>

                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @forelse ($projects ?? [] as $project)
                        <a href="#">
                            <div class="group relative">
                                @if ($project->image)
                                    {{-- <img src="{{ asset('storage/' . $project->image) }}" width="150" alt="Project Image"> --}}
                                    <img src="{{ asset('storage/' . $project->image) }}"
                                        alt="Front of men&#039;s Basic Tee in black."
                                        class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80" />
                                @else
                                    <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=black&shade=800"
                                        alt="Front of men&#039;s Basic Tee in black."
                                        class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80" />
                                @endif
                                <div class="mt-4 flex justify-between">
                                    <div>
                                        <h3 class="text-sm text-gray-700">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $project->name }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p>You have not joined or created any projects yet.</p>
                    @endforelse
                </div>
            </div>
        </div>


        <ul>
            <li></li>
        </ul>
        <a href="{{ route('projects.create') }}">Create Project</a> |
        <a href="{{ route('projects.join') }}">Join Project</a>
    </div>
@endsection
