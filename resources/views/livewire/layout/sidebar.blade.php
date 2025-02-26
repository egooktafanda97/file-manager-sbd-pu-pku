 <!-- Sidebar -->
 <div class="sidebar" id="sidebar">
     <div class="sidebar-inner slimscroll">
         <div class="sidebar-menu" id="sidebar-menu">
             <nav class="greedys sidebar-horizantal">
                 <ul class="list-inline-item list-unstyled links">
                     <li class="menu-title"><span>Main</span></li>
                     <li>
                         <a href="customers.html">
                             <i class="fe fe-users"></i>
                             <span>Drive</span>
                         </a>
                     </li>
                     <li>
                         <a href="customers.html">
                             <i class="fe fe-users"></i>
                             <span>Favorit</span>
                         </a>
                     </li>
                     <li>
                         <a href="customers.html">
                             <i class="fe fe-share"></i>
                             <span>Share</span>
                         </a>
                     </li>
                 </ul>

                 <!-- /Settings -->
             </nav>
             <ul class="sidebar-vertical">
                 <!-- Main -->
                 <li class="menu-title"><span>Main</span></li>
                 <li>
                     <a href="{{ route('dashboard') }}">
                         <i class="fe fe-home"></i>
                         <span>Beranda</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('file-manager.index') }}">
                         <i class="fe fe-folder"></i>
                         <span>Drive</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('file-manager.favorite') }}">
                         <i class="fe fe-star"></i>
                         <span>Favorit</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('file-manager.share') }}">
                         <i class="fe fe-share"></i>
                         <span>Share</span>
                     </a>
                 </li>

                 @if (!empty(auth()) && (auth()?->user()?->level ?? false) == 'super-admin')
                     <li>
                         <a href="{{ route('user.index') }}">
                             <i class="fe fe-user"></i>
                             <span>User</span>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('user.permissions') }}">
                             <i class="fe fe-lock"></i>
                             <span>Role & Permission</span>
                         </a>
                     </li>
                 @endif
                 {{-- <li>
                     <a href="customers.html">
                         <i class="fe fe-trash"></i>
                         <span>Trash</span>
                     </a>
                 </li> --}}
                 <li class="menu-title"><span>Folder</span></li>
                 @php
                     $rootFolder = \App\Models\FileManager::where('parent_id', null)->where('type', 'folder')->get();
                 @endphp
                 @foreach ($rootFolder as $folder)
                     <li>
                         <a href="{{ route('file-manager.index', ['uuid' => $folder->uuid]) }}">
                             <i class="fe fe-folder"></i>
                             <span>{{ $folder->name }}</span>
                         </a>
                     </li>
                 @endforeach
             </ul>
         </div>

     </div>
 </div>
 <!-- /Sidebar -->
