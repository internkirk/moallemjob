<div class="sticky">
    <div class="main-menu main-sidebar main-sidebar-sticky side-menu">
        <div class="main-sidebar-header main-container-1 active">
            <div class="sidemenu-logo">
                <a class="main-logo" href="index.html">
                    <img src="{{asset('assets/img/brand/logo-light.png')}}" class="header-brand-img desktop-logo"
                        alt="logo">
                    <img src="{{asset('assets/img/brand/icon-light.png')}}" class="header-brand-img icon-logo"
                        alt="logo">
                    <img src="{{asset('assets/img/brand/logo.png')}}" class="header-brand-img desktop-logo theme-logo"
                        alt="logo">
                    <img src="{{asset('assets/img/brand/icon.png')}}" class="header-brand-img icon-logo theme-logo"
                        alt="logo">
                </a>
            </div>
            <div class="main-sidebar-body main-body-1">
                <div class="slide-left disabled" id="slide-left"><i class="fe fe-chevron-left"></i></div>
                <ul class="menu-nav nav">
                    <li class="nav-header"><span class="nav-label">داشبورد</span></li>
                    <li class="nav-item {{Route::is('panel.index') ? 'active open show' : ''}}">
                        <a class="nav-link" href="{{route('panel.index')}}">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-home sidemenu-icon menu-icon"></i>
                            <span class="sidemenu-label">صفحه اصلی</span>
                        </a>
                    </li>
                    <li
                        class="nav-item {{(Route::is('panel.admin.index') | Route::is('panel.admin.create') | Route::is('panel.admin.edit') | Route::is('panel.teacher.index') | Route::is('panel.teacher.create') | Route::is('panel.teacher.edit') | Route::is('panel.teacher.academic.background.create') | Route::is('panel.teacher.academic.background.edit') | Route::is('panel.teacher.academic.background.show') | Route::is('panel.teacher.job.background.create') | Route::is('panel.teacher.job.background.edit') | Route::is('panel.teacher.job.background.show') | Route::is('panel.teacher.job.in.demand.create') | Route::is('panel.teacher.job.in.demand.create') | Route::is('panel.teacher.job.in.demand.edit') | Route::is('panel.teacher.job.in.demand.show') | Route::is('panel.teacher.skill.create')  | Route::is('panel.teacher.skill.edit') | Route::is('panel.teacher.skill.show')) ? 'active open show' : ''}}">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-minus sidemenu-icon menu-icon"></i>
                            <span class="sidemenu-label">
                                مدیریت کاربران
                            </span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul
                            class="nav-sub {{(Route::is('panel.admin.index') | Route::is('panel.admin.create') | Route::is('panel.teacher.index') | Route::is('panel.teacher.create')) ? 'active open' : ''}}">
                            <li
                                class="nav-sub-item {{(Route::is('panel.admin.index') | Route::is('panel.admin.create')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.admin.index') | Route::is('panel.admin.create')) ? 'active' : ''}}"
                                    href="{{route('panel.admin.index')}}">ادمین </a>
                            </li>
                            <li
                                class="nav-sub-item {{(Route::is('panel.users.index') | Route::is('panel.users.create')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.users.index') | Route::is('panel.users.create')) ? 'active' : ''}}"
                                    href="{{route('panel.users.index')}}">کاربران </a>
                            </li>
                            <li
                                class="nav-sub-item {{(Route::is('panel.teacher.index') | Route::is('panel.teacher.create')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.teacher.index') | Route::is('panel.teacher.create')) ? 'active' : ''}}"
                                    href="{{route('panel.teacher.index')}}">معلم ها </a>
                            </li>
                        </ul>
                    </li>
                    <li @if (Route::is('panel.setting.edit')) class="nav-item active open show" @else class="nav-item lklklk"  @endif>
                        <a class="nav-link with-sub " href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-minus sidemenu-icon menu-icon"></i>
                            <span class="sidemenu-label">
                                تنظیمات
                            </span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub {{(Route::is('panel.setting.edit') | Route::is('panel.setting.index') | Route::is('panel.setting.create')) ? 'active open' : ''}}">
                            <li class="nav-sub-item {{(Route::is('panel.setting.edit')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.setting.edit')) ? 'active' : ''}}"
                                    href="{{route('panel.setting.index')}}">تنظیمات </a>
                            </li>
                            <li class="nav-sub-item {{(Route::is('panel.feature.management.edit')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.feature.management.edit')) ? 'active' : ''}}"
                                    href="{{route('panel.feature.management.index')}}">مدیریت ویژگی </a>
                            </li>
                            <li class="nav-sub-item {{(Route::is('panel.setting.price.edit')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.setting.price.edit')) ? 'active' : ''}}"
                                    href="{{route('panel.setting.price.index')}}">مدیریت قیمت ها </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-minus sidemenu-icon menu-icon"></i>
                            <span class="sidemenu-label">
                                مقالات
                            </span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('panel.blog.index')}}">لیست مقالات </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{(Route::is('panel.academy.index') | Route::is('panel.academy.edit')) ? 'active open show' : ''}}">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-minus sidemenu-icon menu-icon"></i>
                            <span class="sidemenu-label">
                                آموزشگاه
                            </span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('panel.academy.index')}}">لیست آموزشگاه ها </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{(Route::is('panel.plan.index') | Route::is('panel.plan.edit')) ? 'active open show' : ''}}">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-minus sidemenu-icon menu-icon"></i>
                            <span class="sidemenu-label">
                                پلن ها
                            </span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('panel.plan.index')}}">لیست پلن ها </a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('panel.suggested.resume.algorithm.index')}}">تنظیمات الگورتیم رزومه های پیشنهادی </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item {{(Route::is('panel.advertisement.index') | Route::is('panel.advertisement.create') | Route::is('panel.advertisement.edit') ) ? 'active open show' : ''}}">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-minus sidemenu-icon menu-icon"></i>
                            <span class="sidemenu-label">
                                 آگهی ها
                            </span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul
                            class="nav-sub {{(Route::is('panel.advertisement.index') | Route::is('panel.advertisement.create') | Route::is('panel.teacher.index') | Route::is('panel.teacher.create')) ? 'active open' : ''}}">
                            <li
                                class="nav-sub-item {{(Route::is('panel.advertisement.index') | Route::is('panel.advertisement.create')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.advertisement.index') | Route::is('panel.advertisement.create')) ? 'active' : ''}}"
                                    href="{{route('panel.advertisement.index')}}">لیست آگهی ها </a>
                                    
                            </li>
                             <li
                                class="nav-sub-item {{(Route::is('panel.major.index') | Route::is('panel.major.create')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.major.index') | Route::is('panel.major.create')) ? 'active' : ''}}"
                                    href="{{route('panel.major.index')}}">تنظیمات </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item {{(Route::is('panel.order.index') | Route::is('panel.order.show') | Route::is('panel.order.profile.index') | Route::is('panel.order.profile.show') ) ? 'active open show' : ''}}">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-minus sidemenu-icon menu-icon"></i>
                            <span class="sidemenu-label">
                                 سفارشات
                            </span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul
                            class="nav-sub {{(Route::is('panel.order.index') | Route::is('panel.order.show')) ? 'active open' : ''}}">
                            <li
                                class="nav-sub-item {{(Route::is('panel.order.index') | Route::is('panel.order.show')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.order.index') | Route::is('panel.order.show')) ? 'active' : ''}}"
                                    href="{{route('panel.order.index')}}">سفارشات پکیج </a>
                            </li>
                            <li
                                class="nav-sub-item {{(Route::is('panel.order.profile.index') | Route::is('panel.order.profile.show')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.order.profile.index') | Route::is('panel.order.profile.show')) ? 'active' : ''}}"
                                    href="{{route('panel.order.profile.index')}}">سفارشات پروفایل </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item {{(Route::is('panel.prime.teacher.index') | Route::is('panel.prime.teacher.show') | Route::is('panel.prime.teacher.request.index') | Route::is('panel.prime.teacher.request.show') ) ? 'active open show' : ''}}">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-minus sidemenu-icon menu-icon"></i>
                            <span class="sidemenu-label">
                                 معلمان برتر
                            </span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul
                            class="nav-sub {{(Route::is('panel.prime.teacher.index') | Route::is('panel.prime.teacher.show')) ? 'active open' : ''}}">
                            <li
                                class="nav-sub-item {{(Route::is('panel.prime.teacher.index') | Route::is('panel.prime.teacher.show')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.prime.teacher.index') | Route::is('panel.prime.teacher.show')) ? 'active' : ''}}"
                                    href="{{route('panel.prime.teacher.index')}}">لیست معلمان برتر  </a>
                            </li>
                            <li
                                class="nav-sub-item {{(Route::is('panel.prime.teacher.requests.index') | Route::is('panel.prime.teacher.requests.show')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.prime.teacher.requests.index') | Route::is('panel.prime.teacher.requests.show')) ? 'active' : ''}}"
                                    href="{{route('panel.prime.teacher.requests.index')}}">لیست درخواست ها  </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item {{(Route::is('panel.prime.academy.index') | Route::is('panel.prime.academy.show') | Route::is('panel.prime.academy.request.index') | Route::is('panel.prime.academy.request.show') ) ? 'active open show' : ''}}">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-minus sidemenu-icon menu-icon"></i>
                            <span class="sidemenu-label">
                                 آموزشگاه های برتر
                            </span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul
                            class="nav-sub {{(Route::is('panel.prime.academy.index') | Route::is('panel.prime.academy.show')) ? 'active open' : ''}}">
                            <li
                                class="nav-sub-item {{(Route::is('panel.prime.academy.index') | Route::is('panel.prime.academy.show')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.prime.academy.index') | Route::is('panel.prime.academy.show')) ? 'active' : ''}}"
                                    href="{{route('panel.prime.academy.index')}}">لیست آموزشگاه های برتر  </a>
                            </li>
                            <li
                                class="nav-sub-item {{(Route::is('panel.prime.academy.requests.index') | Route::is('panel.prime.academy.requests.show')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.prime.academy.requests.index') | Route::is('panel.prime.academy.requests.show')) ? 'active' : ''}}"
                                    href="{{route('panel.prime.academy.requests.index')}}">لیست درخواست ها  </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item {{(Route::is('panel.shop.course.index') | Route::is('panel.shop.course.show') | Route::is('panel.shop.course.episode.index') | Route::is('panel.shop.course.episode.show') ) ? 'active open show' : ''}}">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-minus sidemenu-icon menu-icon"></i>
                            <span class="sidemenu-label">
                                 فروشگاه
                            </span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul
                            class="nav-sub {{(Route::is('panel.shop.course.index') | Route::is('panel.shop.course.show')) ? 'active open' : ''}}">
                            <li
                                class="nav-sub-item {{(Route::is('panel.shop.course.index') | Route::is('panel.shop.course.show')|Route::is('panel.shop.course.episode.index') | Route::is('panel.shop.course.episode.show')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.shop.course.index') | Route::is('panel.shop.course.show')|Route::is('panel.shop.course.episode.index') | Route::is('panel.shop.course.episode.show')) ? 'active' : ''}}"
                                    href="{{route('panel.shop.course.index')}}">دوره ها  </a>
                            </li>
                            <li
                                class="nav-sub-item {{(Route::is('panel.shop.product.index') | Route::is('panel.shop.product.show')| Route::is('panel.shop.product.create') | Route::is('panel.shop.product.edit')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.shop.product.index') | Route::is('panel.shop.product.show')|Route::is('panel.shop.product.create') | Route::is('panel.shop.product.edit')) ? 'active' : ''}}"
                                    href="{{route('panel.shop.product.index')}}">محصولات  </a>
                            </li>
                            <li
                                class="nav-sub-item {{(Route::is('panel.shop.course.category.index')  ) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.shop.course.category.index')  ) ? 'active' : ''}}"
                                    href="{{route('panel.shop.course.category.index')}}"> دسته بندی  ها  </a>
                            </li>
                            {{-- <li
                                class="nav-sub-item {{(Route::is('panel.prime.academy.requests.index') | Route::is('panel.prime.academy.requests.show')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.prime.academy.requests.index') | Route::is('panel.prime.academy.requests.show')) ? 'active' : ''}}"
                                    href="{{route('panel.prime.academy.requests.index')}}">محصولات  </a>
                            </li> --}}
                        </ul>
                    </li>
                    <li
                    class="nav-item {{(Route::is('panel.pro.resume.request.index')) ? 'active open show' : ''}}">
                    <a class="nav-link with-sub" href="javascript:void(0)">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-minus sidemenu-icon menu-icon"></i>
                        <span class="sidemenu-label">
                             رزومه های حرفه ای
                        </span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul
                        class="nav-sub {{(Route::is('panel.pro.resume.request.index')) ? 'active open' : ''}}">
                        <li
                            class="nav-sub-item {{(Route::is('panel.pro.resume.request.index')) ? 'active' : ''}}">
                            <a class="nav-sub-link {{(Route::is('panel.pro.resume.request.index')) ? 'active' : ''}}"
                                href="{{route('panel.pro.resume.request.index')}}">لیست درخواست ها  </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{(Route::is('panel.ticket.index')) ? 'active open show' : ''}}">
                        <a class="nav-link with-sub" href="javascript:void(0)">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="ti-minus sidemenu-icon menu-icon"></i>
                            <span class="sidemenu-label">
                                تیکت ها
                            </span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="nav-sub {{(Route::is('panel.ticket.index')) ? 'active open' : ''}}">
                            <li class="nav-sub-item {{(Route::is('panel.ticket.index')) ? 'active' : ''}}">
                                <a class="nav-sub-link {{(Route::is('panel.ticket.index')) ? 'active' : ''}}"
                                    href="{{route('panel.ticket.index')}}">لیست تیکت ها </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="slide-right" id="slide-right"><i class="fe fe-chevron-right"></i></div>
            </div>
        </div>
    </div>
</div>