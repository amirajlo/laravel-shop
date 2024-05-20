<aside id="sidebar" class="sidebar">
    <section class="sidebar-container">
        <section class="sidebar-wrapper">

            <a href="/" class="sidebar-link" target="_blank">
                <i class="fas fa-shopping-cart"></i>
                <span>فروشگاه</span>
            </a>

            <hr>


            <a href="/admin" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>خانه</span>
            </a>


            <a href="{{ route('admin.user.admin-user.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>کاربران ادمین</span>
            </a>
            <a href="{{ route('admin.user.customer.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>مشتریان</span>
            </a>
            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>سطوح دسترسی</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{ route('admin.user.role.index') }}">مدیریت نقش ها</a>
                    <a href="{{ route('admin.user.permission.index') }}">مدیریت دسترسی ها</a>

                </section>
            </section>

            <a href="{{ route('admin.categories.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>دسته بندی</span>
            </a>

            <a href="{{ route('admin.tags.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>برچسب ها</span>
            </a>


        </section>
    </section>
</aside>
