<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">DAFTAR MENU</li>
            <li><a href="/cabang"><i class="fa fa-home"></i> Bank Sampah</a></li>
            <li><a href="/nasabah"><i class="fa fa-child"></i> Nasabah</a></li>
            <li><a href="/item"><i class="fa fa-archive"></i> Item</a></li>
            <li><a href="/setor"><i class="fa fa-book"></i> Penyetoran</a></li>
            <li><a href="/jual"><i class="fa fa-money"></i> Penjualan</a></li>
            <li><a href="/statistics/penyetoran"><i class="fa fa-bar-chart"></i>Statistik Penyetoran</a></li>
            <li><a href="/statistics/penjualan"><i class="fa fa-bar-chart"></i>Statistik Penjualan</a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>