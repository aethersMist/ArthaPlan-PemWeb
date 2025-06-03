@props(['id', 'title'])

<div id="{{ $id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full inset-0 h-modal h-full justify-center items-center bg-dark/75">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-base rounded-lg shadow-lg ">
            <!-- Header -->
            <div class="flex justify-between items-center p-5 rounded-t border-b ">
                <h3 class="text-xl font-bold text-dark ">{{ $title }}</h3>
                <button type="button" class="text-primary-dark bg-transparent hover:bg-gray-200 hover:text-primary-dark rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="{{ $id }}">
                    <i class="fa-solid fa-xmark fa-md"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="p-4 space-y-4">
                {{ $slot }}
            </div>

        </div>
    </div>
</div>
