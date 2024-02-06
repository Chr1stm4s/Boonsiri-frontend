<nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="./">
            <img src="../images/logo.png" alt="" class="header-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php if($page == "dashboard") { echo "active"; } ?>" href="./">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($page == "promotions") { echo "active"; } ?>" href="./promotions.php">Promotions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($page == "courier") { echo "active"; } ?>" href="./courier.php">Courier</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($page == "category") { echo "active"; } ?>" href="./category.php">Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($page == "products") { echo "active"; } ?>" href="./products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($page == "branches") { echo "active"; } ?>" href="./branches.php">Branches</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($page == "jobs") { echo "active"; } ?>" href="./jobs.php">Jobs</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Orders
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="./orders.php">Normal</a></li>
                        <li><a class="dropdown-item" href="./pre-orders.php">Pre-orders</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($page == "claims") { echo "active"; } ?>" href="./claims.php">Claims</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($page == "customers") { echo "active"; } ?>" href="./customers.php">Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($page == "contact") { echo "active"; } ?>" href="./contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($page == "articles") { echo "active"; } ?>" href="./articles.php">Articles</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Banners
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="./banners.php?api=banner&location=1&size=header">Header Home Main</a></li>
                        <li><a class="dropdown-item" href="./banners.php?api=banner&location=2&size=header-x">Header Home Square #1</a></li>
                        <li><a class="dropdown-item" href="./banners.php?api=banner&location=3&size=header-x">Header Home Square #2</a></li>
                        <li><a class="dropdown-item" href="./banners.php?api=banner&location=4&size=header-x">Header Home Square #3</a></li>
                        <li><a class="dropdown-item" href="./banners.php?api=banner&location=5&size=header-x">Header Home Square #4</a></li>
                        <li><a class="dropdown-item" href="./banners.php?api=featured&location=1&size=featured">Featured</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>