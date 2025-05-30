<div class="space-y-6">
    <!-- Header Info -->
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-500 dark:text-gray-400">Participant:</span>
                <span class="ml-2 font-semibold text-gray-900 dark:text-gray-100">{{ $record->name }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-500 dark:text-gray-400">Event:</span>
                <span class="ml-2 font-semibold text-gray-900 dark:text-gray-100">{{ $record->event->nama }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-500 dark:text-gray-400">Registration Type:</span>
                <span class="ml-2 font-semibold text-gray-900 dark:text-gray-100">{{ $record->jenis_pendaftaran_label }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-500 dark:text-gray-400">Payment Status:</span>
                <span class="ml-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($record->payment_status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @elseif($record->payment_status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                        @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                        {{ $record->payment_status_label }}
                    </span>
                </span>
            </div>
        </div>
    </div>

    <!-- Documents Status -->
    <div class="border-l-4 
        @if($record->documents_complete) border-green-400 bg-green-50 dark:bg-green-900/20 dark:border-green-500
        @else border-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 dark:border-yellow-500 @endif
        p-4 rounded-r-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                @if($record->documents_complete)
                    <svg class="h-5 w-5 text-green-400 dark:text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                @else
                    <svg class="h-5 w-5 text-yellow-400 dark:text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                @endif
            </div>
            <div class="ml-3">
                <p class="text-sm 
                    @if($record->documents_complete) text-green-700 dark:text-green-300
                    @else text-yellow-700 dark:text-yellow-300 @endif
                    font-medium">
                    {{ $record->documents_status_message }}
                </p>
                @if(!$record->documents_complete && $record->payment_status === 'approved')
                <p class="mt-1 text-sm 
                    @if($record->documents_complete) text-green-600 dark:text-green-400
                    @else text-yellow-600 dark:text-yellow-400 @endif">
                    Missing documents: {{ implode(', ', $record->missing_documents) }}
                </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Documents List -->
    <div class="space-y-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Competition Documents</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Paper Document -->
            <div class="border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-red-500 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Paper Document</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Makalah</p>
                        </div>
                    </div>
                    <div>
                        @if($record->google_drive_makalah)
                            <a href="{{ $record->google_drive_makalah }}" target="_blank" 
                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                View Document
                            </a>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-gray-500 bg-gray-100 dark:text-gray-400 dark:bg-gray-700">
                                Not uploaded
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Attachment Document -->
            <div class="border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Attachment Document</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Lampiran</p>
                        </div>
                    </div>
                    <div>
                        @if($record->google_drive_lampiran)
                            <a href="{{ $record->google_drive_lampiran }}" target="_blank" 
                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                View Document
                            </a>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-gray-500 bg-gray-100 dark:text-gray-400 dark:bg-gray-700">
                                Not uploaded
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Before Video -->
            <div class="border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Before Innovation Video</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Video Sebelum</p>
                        </div>
                    </div>
                    <div>
                        @if($record->google_drive_video_sebelum)
                            <a href="{{ $record->google_drive_video_sebelum }}" target="_blank" 
                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.828 2.828a1 1 0 01.293.707V15M9 10V9a4 4 0 118 0v1M9 10H5.5a2.5 2.5 0 000 5H9"/>
                                </svg>
                                Watch Video
                            </a>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-gray-500 bg-gray-100 dark:text-gray-400 dark:bg-gray-700">
                                Not uploaded
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- After Video -->
            <div class="border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">After Innovation Video</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Video Sesudah</p>
                        </div>
                    </div>
                    <div>
                        @if($record->google_drive_video_sesudah)
                            <a href="{{ $record->google_drive_video_sesudah }}" target="_blank" 
                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.828 2.828a1 1 0 01.293.707V15M9 10V9a4 4 0 118 0v1M9 10H5.5a2.5 2.5 0 000 5H9"/>
                                </svg>
                                Watch Video
                            </a>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-gray-500 bg-gray-100 dark:text-gray-400 dark:bg-gray-700">
                                Not uploaded
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Members if applicable -->
    @if($record->jenis_pendaftaran === 'tim' && $record->teamMembers->count() > 0)
    <div class="space-y-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Team Members ({{ $record->teamMembers->count() }})</h3>
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <div class="space-y-2">
                @foreach($record->teamMembers as $member)
                <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                    <div class="flex items-center">
                        @if($member->is_ketua)
                            <svg class="h-5 w-5 text-yellow-400 dark:text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @else
                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $member->nama }}
                                @if($member->is_ketua)
                                    <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Leader
                                    </span>
                                @endif
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $member->email }} • {{ $member->kontak }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Additional Information -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700 dark:text-blue-300">
                    <strong class="font-semibold">Important:</strong> All Google Drive links should be accessible with "Anyone with the link can view" permission. Documents will be reviewed by our judges for the competition evaluation.
                </p>
            </div>
        </div>
    </div>
</div>