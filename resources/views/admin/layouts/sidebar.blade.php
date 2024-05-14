<aside id="sidebar" class="sidebar">
    <section class="sidebar-container">
        <section class="sidebar-wrapper">

            <a href="#" class="sidebar-link" target="_blank">
                <i class="fas fa-shopping-cart"></i>
                <span>فروشگاه</span>
            </a>

            <hr>


            <a href="#" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>خانه</span>
            </a>




            <section class="sidebar-part-title">بخش کاربران</section>
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
                    <a href="#">مدیریت نقش ها</a>
                    <a href="#">مدیریت دسترسی ها</a>
                    <a href="#">فروش شگفت انگیز</a>
                </section>
            </section>





            <section class="sidebar-part-title">اطلاع رسانی</section>
            <a href="#" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>اعلامیه ایمیلی</span>
            </a>
            <a href="#" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>اعلامیه پیامکی</span>
            </a>



            <section class="sidebar-part-title">تنظیمات</section>
            <a href="#" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>تنظیمات</span>
            </a>

        </section>
    </section>
</aside>
