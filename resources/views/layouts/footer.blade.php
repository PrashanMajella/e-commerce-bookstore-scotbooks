<footer class="p-4 bg-white rounded-lg shadow md:px-6 md:py-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <a href="{{ route('root') }}" class="flex items-center mb-4 sm:mb-0 gap-2">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap">Scotbooks</span>
        </a>
        <ul class="flex flex-wrap items-center mb-6 text-sm text-gray-500 sm:mb-0">
            <li>
                <a href="{{ route('about.index') }}" class="mr-4 hover:underline md:mr-6 ">About</a>
            </li>
            <li>
                <a href="{{ route('law.privacy-policy') }}" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
            </li>
            <li>
                <a href="{{ route('law.terms-conditions') }}" class="mr-4 hover:underline md:mr-6 ">Terms & Conditions</a>
            </li>
            <li>
                <a href="{{ route('contact.index') }}" class="hover:underline">Contact</a>
            </li>
        </ul>
    </div>
    <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
    <span class="block text-sm text-gray-500 sm:text-center">© <a href="{{ route('root') }}" class="hover:underline">Scotbooks™</a>. All Rights Reserved.
    </span>
</footer>
