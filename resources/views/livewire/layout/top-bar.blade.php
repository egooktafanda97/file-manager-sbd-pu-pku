 <!-- Header -->
 <div class="header header-one">

     <a class="d-inline-flex d-sm-inline-flex align-items-center d-md-inline-flex d-lg-none align-items-center device-logo"
         href="index.html">
         <img alt="Logo" class="img-fluid logo2"
             src="https://upload.wikimedia.org/wikipedia/commons/3/30/Logo_lambang_kota_pekanbaru.png">
     </a>
     <div class="main-logo d-inline float-start d-lg-flex align-items-center d-none d-sm-none d-md-none">
         <div class="logo-white">
             <a href="index.html">
                 <img alt="Logo" class="img-fluid logo-blue"
                     src="https://upload.wikimedia.org/wikipedia/commons/3/30/Logo_lambang_kota_pekanbaru.png">
             </a>
             <a href="index.html">
                 <img alt="Logo" class="img-fluid logo-small"
                     src="https://upload.wikimedia.org/wikipedia/commons/3/30/Logo_lambang_kota_pekanbaru.png">
             </a>
         </div>
         <div class="logo-color">
             <a href="index.html">
                 <h3>SBD PU PEKANBARU</h3>
                 {{-- <img alt="Logo" class="img-fluid logo-blue" src="{{ asset('') }}assets/img/logo.png"> --}}
             </a>
             <a href="index.html">
                 {{-- SBD PU Pekanbaru --}}
                 {{-- <img alt="Logo" class="img-fluid logo-small" src="{{ asset('') }}assets/img/logo-small.png"> --}}
             </a>
         </div>
     </div>

     <!-- Sidebar Toggle -->
     <a href="javascript:void(0);" id="toggle_btn">
         <span class="toggle-bars">
             <span class="bar-icons"></span>
             <span class="bar-icons"></span>
             <span class="bar-icons"></span>
             <span class="bar-icons"></span>
         </span>
     </a>
     <!-- /Sidebar Toggle -->

     <!-- Search -->
     <div class="top-nav-search">
         {{-- <div class="w-full max-w-md relative">
             <div class="relative search-form">
                 <input
                     class="w-full border border-gray-300 rounded-lg form-control text-lg focus:outline-none focus:ring-2 focus:ring-indigo-600"
                     id="searchInput" placeholder="Search the content here..." type="text">
                 <button class="absolute right-3 top-2 text-gray-500 text-xl" id="searchIcon">
                     <img alt="img" src="{{ asset('') }}assets/img/icons/search.svg">
                 </button>
             </div>
             <ul class="absolute w-full bg-white border border-gray-200 rounded-lg mt-2 hidden shadow-md max-h-60 overflow-y-auto"
                 id="suggestionBox"></ul>
         </div> --}}
         <form class="search-form" onsubmit="event.preventDefault()">
             <input class="form-control" id="searchInput" placeholder="file search" type="text">
             <button class="btn" type="submit">
                 <img alt="img" src="{{ asset('') }}assets/img/icons/search.svg">
             </button>
             <ul class="absolute w-full bg-white border border-gray-200 rounded-lg mt-2 hidden shadow-md max-h-60 overflow-y-auto"
                 id="suggestionBox"></ul>
         </form>
     </div>
     <!-- /Search -->

     <!-- Mobile Menu Toggle -->
     <a class="mobile_btn" id="mobile_btn">
         <i class="fas fa-bars"></i>
     </a>
     <!-- /Mobile Menu Toggle -->

     <!-- Header Menu -->
     <ul class="nav nav-tabs user-menu">
         <!-- Flag -->
         {{-- <li class="nav-item dropdown has-arrow flag-nav">
             <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button">
                 <img alt="flag" src="{{ asset('') }}assets/img/flags/us1.png"><span>English</span>
             </a>
             <div class="dropdown-menu dropdown-menu-right">
                 <a class="dropdown-item" href="javascript:void(0);">
                     <img alt="flag" src="{{ asset('') }}assets/img/flags/us.png"><span>English</span>
                 </a>
                 <a class="dropdown-item" href="javascript:void(0);">
                     <img alt="flag" src="{{ asset('') }}assets/img/flags/fr.png"><span>French</span>
                 </a>
                 <a class="dropdown-item" href="javascript:void(0);">
                     <img alt="flag" src="{{ asset('') }}assets/img/flags/es.png"><span>Spanish</span>
                 </a>
                 <a class="dropdown-item" href="javascript:void(0);">
                     <img alt="flag" src="{{ asset('') }}assets/img/flags/de.png"><span>German</span>
                 </a>
             </div>
         </li> --}}
         <!-- /Flag -->


         {{-- <li class="nav-item  has-arrow dropdown-heads ">
             <a class="toggle-switch" href="javascript:void(0);">
                 <i class="fe fe-moon"></i>
             </a>
         </li>
         <li class="nav-item dropdown  flag-nav dropdown-heads">
             <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button">
                 <i class="fe fe-bell"></i> <span class="badge rounded-pill"></span>
             </a>
             <div class="dropdown-menu notifications">
                 <div class="topnav-dropdown-header">
                     <div class="notification-title">Notifications <a href="notifications.html">View all</a>
                     </div>
                     <a class="clear-noti d-flex align-items-center" href="javascript:void(0)">Mark all as read
                         <i class="fe fe-check-circle"></i></a>
                 </div>
                 <div class="noti-content">
                     <ul class="notification-list">
                         <li class="notification-message">
                             <a href="profile.html">
                                 <div class="d-flex">
                                     <span class="avatar avatar-md active">
                                         <img alt="avatar-img" class="avatar-img rounded-circle"
                                             src="{{ asset('') }}assets/img/profiles/avatar-02.jpg">
                                     </span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">Lex Murphy</span>
                                             requested access to <span class="noti-title">UNIX directory tree
                                                 hierarchy</span></p>
                                         <div class="notification-btn">
                                             <span class="btn btn-primary">Accept</span>
                                             <span class="btn btn-outline-primary">Reject</span>
                                         </div>
                                         <p class="noti-time"><span class="notification-time">Today at 9:42
                                                 AM</span></p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <li class="notification-message">
                             <a href="profile.html">
                                 <div class="d-flex">
                                     <span class="avatar avatar-md active">
                                         <img alt="avatar-img" class="avatar-img rounded-circle"
                                             src="{{ asset('') }}assets/img/profiles/avatar-10.jpg">
                                     </span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">Ray Arnold</span>
                                             left 6 comments <span class="noti-title">on Isla Nublar SOC2
                                                 compliance report</span></p>
                                         <p class="noti-time"><span class="notification-time">Yesterday at
                                                 11:42 PM</span></p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <li class="notification-message">
                             <a href="profile.html">
                                 <div class="d-flex">
                                     <span class="avatar avatar-md">
                                         <img alt="avatar-img" class="avatar-img rounded-circle"
                                             src="{{ asset('') }}assets/img/profiles/avatar-13.jpg">
                                     </span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">Dennis Nedry</span>
                                             commented on <span class="noti-title"> Isla Nublar SOC2 compliance
                                                 report</span></p>
                                         <blockquote>
                                             “Oh, I finished de-bugging the phones, but the system's compiling
                                             for eighteen minutes, or twenty. So, some minor systems may go on
                                             and off for a while.”
                                         </blockquote>
                                         <p class="noti-time"><span class="notification-time">Yesterday at 5:42
                                                 PM</span></p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <li class="notification-message">
                             <a href="profile.html">
                                 <div class="d-flex">
                                     <span class="avatar avatar-md">
                                         <img alt="avatar-img" class="avatar-img rounded-circle"
                                             src="{{ asset('') }}assets/img/profiles/avatar-05.jpg">
                                     </span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">John Hammond</span>
                                             created <span class="noti-title">Isla Nublar SOC2 compliance
                                                 report</span></p>
                                         <p class="noti-time"><span class="notification-time">Last Wednesday at
                                                 11:15 AM</span></p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                     </ul>
                 </div>
                 <div class="topnav-dropdown-footer">
                     <a href="#">Clear All</a>
                 </div>
             </div>
         </li> --}}
         <li class="nav-item  has-arrow dropdown-heads ">
             <a class="win-maximize" href="javascript:void(0);">
                 <i class="fe fe-maximize"></i>
             </a>
         </li>
         <!-- User Menu -->
         <li class="nav-item dropdown">
             <a class="user-link  nav-link" data-bs-toggle="dropdown" href="javascript:void(0)">
                 <span class="user-img">
                     <img alt="img" class="profilesidebar"
                         src="https://upload.wikimedia.org/wikipedia/commons/3/30/Logo_lambang_kota_pekanbaru.png">
                     <span class="animate-circle"></span>
                 </span>
                 <span class="user-content">
                     <span class="user-details">
                         {{ Auth::user()->name ?? 'X' }}
                     </span>
                     <span class="user-name">
                         {{ Auth::user()->email ?? 'X' }}
                     </span>
                 </span>
             </a>
             <div class="dropdown-menu menu-drop-user">
                 <div class="profilemenu">
                     {{-- <div class="subscription-menu">
                         <ul>
                             <li>
                                 <a class="dropdown-item" href="profile.html">Profile</a>
                             </li>
                             <li>
                                 <a class="dropdown-item" href="settings.html">Settings</a>
                             </li>
                         </ul>
                     </div> --}}
                     <div class="subscription-logout">
                         <ul>
                             <li class="pb-0">
                                 <a class="dropdown-item" href="{{ route('login') }}" ">
                                     Log Out
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </div>
             </div>
         </li>
         <!-- /User Menu -->

     </ul>

     <!-- /Header Menu -->

 </div>
 <!-- /Header -->


 @push('scripts')
    <script>
        $('#searchInput').on('keyup', function() {
            let query = $(this).val().trim();
            if (query) {
                axios.get(`/file-manager/search-files?search=${query}`)
                    .then(response => {
                        let files = response.data;
                        let suggestionBox = $('#suggestionBox');
                        suggestionBox.empty();
                        if (files.length) {
                            files.forEach(file => {
                                let li = $('<li></li>').addClass(
                                    'p-2 hover:bg-gray-200 cursor-pointer border-b').text(file
                                    .merge_name);
                                li.on('click', function() {
                                    $('#searchInput').val(file.merge_name);
                                    window.location.href =
                                        `/file-manager/${file.parent_uuid}?search=${file.name}`;
                                    suggestionBox.addClass('hidden');
                                });
                                suggestionBox.append(li);
                            });
                            suggestionBox.removeClass('hidden');
                        } else {
                            suggestionBox.addClass('hidden');
                        }
                    })
                    .catch(error => console.error("Error fetching files:", error));
            } else {
                $('#suggestionBox').addClass('hidden');
            }
        });

        $('#searchIcon').on('click', function() {
            let query = $('#searchInput').val().trim();
            if (query) {
                window.open(`/search-files?search=${query}`, "_blank");
            }
        });
    </script>
@endpush
