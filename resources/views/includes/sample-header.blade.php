<div class="header">
    <nav class="navbar py-4">
        <div class="container-fluid">

            <!-- header rightbar icon -->
            <div class="h-right align-items-center mr-5 mr-lg-0 order-3 d-none d-md-flex">
                <div class="dropdown user-profile ml-2 ml-sm-3 d-flex align-items-center zindex-popover">
                    <div class="u-info me-2">
                        <p class="mb-0 text-end line-height-sm text-white"><span class="font-weight-bold">Molly Cornish</span></p>
                        <small-xs class="text-white">Student Profile</small-xs>
                    </div>
                    <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
                        <img class="avatar lg rounded-circle img-thumbnail" src="{{ asset('images/profile_av.png') }}" alt="profile">
                    </a>
                    <div class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-lg-end p-0 m-0">
                        <div class="card border-0 w280">
                            <div class="card-body pb-0">
                                <div class="d-flex py-1">
                                    <img class="avatar rounded-circle" src="{{ asset('images/profile_av.png') }}" alt="profile">
                                    <div class="flex-fill ms-3">
                                        <p class="mb-0"><span class="font-weight-bold">Molly Cornish</span></p>
                                        <small class="">molly.cornish@gamil.com</small>
                                    </div>
                                </div>
                                <div><hr class="dropdown-divider border-dark"></div>
                            </div>
                            <div class="list-group m-2 ">
                                <a href="{{route('admin.student')}}" class="list-group-item list-group-item-action border-0 "><i class="icofont-graduate-alt fs-6 me-3"></i>Student Profile</a>
                                <a href="{{route('admin.authentication.signin')}}" class="list-group-item list-group-item-action border-0 "><i class="icofont-black-board fs-6 me-3"></i>Video Class</a>
                                <a href="{{route('admin.video-classes')}}" class="list-group-item list-group-item-action border-0 "><i class="icofont-logout fs-6 me-3"></i>Signout</a>
                                <div><hr class="dropdown-divider border-dark"></div>
                                <a href="{{route('admin.authentication.signup')}}" class="list-group-item list-group-item-action border-0 "><i class="icofont-contact-add fs-5 me-3"></i>Add personal account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- main menu Search-->
            <div class="order-0 col-lg-4 col-md-4 col-sm-12 col-12 mb-3 mb-md-0 ">
                <div class="input-group flex-nowrap input-group-lg">
                    <a href="{{route('admin.dashboard')}}" class="btn btn-primary"><i class="icofont-arrow-left"></i></a>
                    <span class="input-group-text" id="addon-wrapping"><i class="fa fa-search"></i></span>
                    <input type="search" class="form-control" placeholder="Search" aria-label="search" aria-describedby="addon-wrapping">
                </div>
            </div>

        </div>
    </nav>
</div>