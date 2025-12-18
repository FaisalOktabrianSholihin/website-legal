<div class="flex justify-center w-full border rounded-lg bg-gray-50 dark:bg-gray-900" style="height: 600px;">
    @if ($fileUrl)
        <iframe src="{{ $fileUrl }}" width="100%" height="100%" style="border: none;" class="rounded-lg">
        </iframe>
    @else
        <div class="flex flex-col items-center justify-center text-gray-400">
            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            <p>Pilih file untuk melihat preview</p>
        </div>
    @endif
</div>
