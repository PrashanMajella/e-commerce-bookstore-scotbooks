<div
    x-data="toast"
    x-show="visible"
    x-transition
    x-cloak
    x-on:notify.window="show($event.detail.message)"
    class="fixed bottom-5 -right-5 w-[400px] md:right-0"
>
    <div id="toast-default" class="relative overflow-hidden flex items-center p-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow" role="alert">
        <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-blue-500 bg-blue-100 rounded-lg">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Fire icon</span>
        </div>
        <div x-text="message" class="ml-3 text-sm font-semibold"></div>
        <button type="button" x-on:click="close" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" data-dismiss-target="#toast-default" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
        <!-- Progress -->
        <div class="pt-2">
            <div
            class="absolute left-0 bottom-0 right-0 h-[4px] bg-black/20"
            :style="{'width': `${percent}%`}"
            ></div>
        </div>
    </div>
</div>