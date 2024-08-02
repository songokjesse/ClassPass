<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    {{--<x-application-logo class="block h-12 w-auto" />--}}

                    <div class="flex justify-between">
                        <h1 class="mt-2 text-2xl font-medium text-gray-900">
                            My Courses
                        </h1>
                        <a href="{{route('dashboard')}}"><x-button>My Courses</x-button></a>
                    </div>

                    <div class=" flex items-center justify-center text-xl font-medium text-gray-900 mt-3 mb-3">
                        Add A Course
                    </div>
                    <hr/>
                    <form class="form mt-6" action="{{route('courses.store')}}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Course Name:</label>
                            <input type="text" name="course_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Course Name" >
                            @error('course_name') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Course Code:</label>
                            <input type="text" name="course_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" placeholder="Enter Course Code" >
                            @error('course_code') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>

                        <div class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <x-button type="submit">
                        Save
                        </x-button>
                        </div>

                    </form>
                    </div>
                </div>

            </div>
        </div>
</x-app-layout>
