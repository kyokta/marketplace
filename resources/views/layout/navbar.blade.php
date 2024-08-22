<header class="w-full p-3 bg-gray-400 flex items-center justify-between">
    <button class="hover:bg-white p-2 rounded-lg" id="btnSidebar">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
    </button>

    <div class="relative">
        <button id="user-menu-button" class="flex items-center focus:outline-none">
            <span class="mr-2 font-bold text-gray-800 hover:text-white">John Doe</span>
            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center profile-icon p-1">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 14c-3.313 0-6 2.687-6 6 0 1.313 1.687 2 3 2h6c1.313 0 3-0.687 3-2 0-3.313-2.687-6-6-6zM12 2a4 4 0 0 1 4 4 4 4 0 0 1-8 0 4 4 0 0 1 4-4z">
                    </path>
                </svg>
            </div>
        </button>

        <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-300">Profile</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-300">Settings</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-300">Logout</a>
        </div>
    </div>
</header>