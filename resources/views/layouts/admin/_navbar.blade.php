<nav class="navbar navbar-header navbar-expand-lg animate__animated animate__bounceInUp" data-background-color="blue2">

  <div class="container-fluid">
    {{-- <div class="collapse" id="search-nav">
      <form class="navbar-left navbar-form nav-search mr-md-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <button type="submit" class="btn btn-search pr-1">
              <i class="fa fa-search search-icon"></i>
            </button>
          </div>
          <input type="text" placeholder="Search ..." class="form-control">
        </div>
      </form>
    </div> --}}
    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
      <li class="nav-item toggle-nav-search hidden-caret">
        <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false"
          aria-controls="search-nav">
          <i class="fa fa-search"></i>
        </a>
      </li>
      @auth
        <li class="nav-item dropdown hidden-caret">
          <a class="text-bold nav-link dropdown-toggle" disabled>
            {{ auth()->user()->name }}
          </a>
        </li>
      @endauth
      {{-- @role('sect_head')
            <li class="nav-item dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="notification">{{ approveSection() }}</span>
                </a>
                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                    <li>
                        <div class="dropdown-title">Kamu mempunyai {{ approveSection() }} permintaan yang belum
                            diapprove</div>
                    </li>
                    <li>
                        <div class="notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                @if (approveSection() > 0)
                                    @foreach (pb() as $message)
                                        <a>
                                            <div class="notif-icon notif-primary">
                                                {{ $loop->iteration }}
                                                <i class="fas fa-tasks"></i>
                                            </div>
                                            <div class="notif-content">
                                                <span class="block">
                                                    {{ $message->no_dokumen }}
                                                </span>
                                                <span class="time">
                                                    Permintaan dari
                                                    {{ $message->user->name }}
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                    @foreach (pr() as $message)
                                        <a>
                                            <div class="notif-icon notif-primary">
                                                {{ $loop->iteration }}
                                                <i class="fas fa-tasks"></i>
                                            </div>
                                            <div class="notif-content">
                                                <span class="block">
                                                    {{ $message->no_dokumen }}
                                                </span>
                                                <span class="time">
                                                    Permintaan dari
                                                    {{ $message->user->name }}
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
            @endrole --}}
      <!-- <li class="nav-item dropdown hidden-caret">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fas fa-layer-group"></i>
                </a>
                <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                    <div class="quick-actions-header">
                        <span class="title mb-1">Quick Actions</span>
                        <span class="subtitle op-8">Shortcuts</span>
                    </div>
                    <div class="quick-actions-scroll scrollbar-outer">
                        <div class="quick-actions-items">
                            <div class="row m-0">
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <i class="flaticon-file-1"></i>
                                        <span class="text">Generated Report</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <i class="flaticon-database"></i>
                                        <span class="text">Create New Database</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <i class="flaticon-pen"></i>
                                        <span class="text">Create New Post</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <i class="flaticon-interface-1"></i>
                                        <span class="text">Create New Task</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <i class="flaticon-list"></i>
                                        <span class="text">Completed Tasks</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <i class="flaticon-file"></i>
                                        <span class="text">Create New Invoice</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li> -->
      <li class="nav-item dropdown hidden-caret">
        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
          <div class="avatar-sm">
            <img src="{{ auth()->user()->getFoto() }}" alt="..." class="user-foto avatar-img rounded-circle">
          </div>
        </a>
        @auth
          <ul class="dropdown-menu dropdown-user animated fadeIn">
            <div class="dropdown-user-scroll scrollbar-outer">
              <li>
                <div class="user-box">
                  <div class="avatar-lg user-foto"><img src="{{ auth()->user()->getFoto() }}" alt="image profile"
                      class="avatar-img rounded"></div>
                  <div class="u-text">
                    <h4>{{ auth()->user()->username }}</h4>
                    <p class="text-muted">{{ auth()->user()->email }}</p>
                  </div>
                </div>
              </li>
              <li>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('profile-user.index') }}"><i class="fas fa-user"></i>
                  My Profile</a>
                <a class="dropdown-item" href="{{ route('profile-user.edit') }}"><i class="fas fa-edit"></i>
                  Ubah Profile</a>
                <a class="dropdown-item" href="{{ route('profile-user.edit_password') }}"><i
                    class="fas fa-lock-open"></i> Ganti Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item btn-logout" href=""><i class="fas fa-sign-out-alt"></i> Logout</a>
              </li>
            </div>
          </ul>
        @endauth
      </li>
    </ul>
  </div>
</nav>
