<div class="amd-topbar">

    <div class="d-flex align-items-center ms-2">
        <i class="fas fa-bars amd-toggle-btn" id="toggleSidebar"></i>
        <span class="amd-page-title">Dashboard</span>
    </div>

    <div class="search-container position-relative">
        <input type="text" class="search-input" placeholder="Search..." id="searchInput">
        <button class="clear-button" id="clearBtn" title="Clear">&times;</button>
        <button class="search-button">
            <i class="fas fa-search"></i>
        </button>
    </div>

    <div class="amd-top-icons">
        <select class="form-select form-select-sm" style="width: auto;">
            <option selected>EN</option>
            <option>ES</option>
            <option>FR</option>
        </select>

        <div class="notification-dropdown">
            <!-- Bell Icon -->
            <i class="fas fa-bell notif-bell" id="notifBell" title="Notifications"></i>

            <!-- Notification Panel (Hidden by default, toggled with JS) -->
            <div class="chat-app notification-panel" id="notificationPanel">
                <div class="chat-header">
                    <h2>Message</h2>
                    <input type="text" placeholder="Search conversation" class="chat-search" />
                </div>

                <div class="chat-tabs">
                    <button class="tab active">ACTIVE</button>
                    <button class="tab">ARCHIVED</button>
                </div>

                <div class="chat-list">
                    <!-- Notification Card 1 -->
                    <div class="chat-card">
                        <img src="https://i.pravatar.cc/100?img=1" class="avatar" />
                        <div class="chat-info">
                            <div class="chat-name-role">
                                <span class="name">Susan</span>
                                <span class="role green">NUTRITIONIST</span>
                            </div>
                            <p class="chat-msg">How's your diet looking today...</p>
                        </div>
                        <div class="chat-date">03 FEB</div>
                    </div>

                    <div class="chat-card">
                        <img src="https://i.pravatar.cc/100?img=2" class="avatar" />
                        <div class="chat-info">
                            <div class="chat-name-role">
                                <span class="name">Gunnar</span>
                                <span class="role orange">COACH</span>
                            </div>
                            <p class="chat-msg">👏👏 We haven't seen you...</p>
                        </div>
                        <div class="chat-date">03 FEB</div>
                    </div>

                    <div class="chat-card">
                        <img src="https://i.pravatar.cc/100?img=3" class="avatar" />
                        <div class="chat-info">
                            <div class="chat-name-role">
                                <span class="name">Sophia</span>
                                <span class="role pink">TRAINER</span>
                            </div>
                            <p class="chat-msg">It's been a while we've seen...</p>
                        </div>
                        <div class="chat-date">03 FEB</div>
                    </div>

                    <div class="chat-card">
                        <img src="https://i.pravatar.cc/100?img=4" class="avatar" />
                        <div class="chat-info">
                            <div class="chat-name-role">
                                <span class="name">Emily</span>
                                <span class="role purple">SUPPORT</span>
                            </div>
                            <p class="chat-msg">Please remember to log your...</p>
                        </div>
                        <div class="chat-date">03 FEB</div>
                    </div>
                </div>

                <div class="chat-nav">
                    <i class="fas fa-inbox" title="Inbox"></i>
                    <i class="fas fa-at" title="Mentions"></i>
                    <i class="fas fa-pen active-icon" title="Compose"></i>
                    <i class="fas fa-cog" title="Settings"></i>
                </div>

            </div>
        </div>

        <!-- Profile -->
        <div class="amd-profile-section">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                @if (Auth::user()->profile_image_url ?? '')
                    <img src="{{ Auth::user()->profile_image_url ?? '' }}" alt="{{ Auth::user()->full_name ?? Auth::user()->name }}"
                        class="amd-profile-imgs rounded-circle me-2" width="36" height="36">
                @elseif(Auth::user()->avatar)
                    <img src="{{ Auth::user()->avatar }}"
                        alt="{{ Auth::user()->full_name ?? Auth::user()->name ?? '' }}" class="amd-profile-imgs rounded-circle me-2" width="36"
                        height="36">
                        @else
                              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->full_name ?? Auth::user()->name ?? '') }}&background=random"
                        alt="{{ Auth::user()->full_name ?? Auth::user()->name ?? '' }}" class="amd-profile-imgs rounded-circle me-2" width="36"
                        height="36">

                @endif
                <span>{{ Auth::user()->full_name ?? Auth::user()->name ?? '' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#"
                        onclick="document.getElementById('logout-form').submit();">Logout</a></li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>

    </div>

</div>
