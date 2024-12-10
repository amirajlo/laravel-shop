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


            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>دسته بندی</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{ route('admin.categories.index',\App\Models\Main::CATEGORY_TYPE_PRODUCT) }}">دسته بندی محصولات</a>
                    <a href="{{ route('admin.categories.index',\App\Models\Main::CATEGORY_TYPE_ARTICLE) }}">دسته بندی مقالات</a>

                    <a href="{{ route('admin.tags.index') }}">مدیریت برچسب ها</a>
                </section>
            </section>

            <a href="{{ route('admin.brands.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>برند</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>محصولات</span>
            </a>
            <a href="{{ route('admin.articles.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>مقالات</span>
            </a>
            <a href="{{ route('admin.comments.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>کامنت ها</span>
            </a>
            <a href="{{ route('admin.addresses.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>آدرس ها</span>
            </a>
            <a href="{{ route('admin.deliveries.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>حمل و نقل</span>
            </a>

            <a href="{{ route('admin.payments.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>پرداخت ها</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>سفارش ها</span>
            </a>

            <a href="{{ route('admin.orderitems.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>خرید های ناتمام</span>
            </a>
            <a href="{{ route('admin.discounts.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>تخفیف ها</span>
            </a>
        </section>
    </section>
</aside>
