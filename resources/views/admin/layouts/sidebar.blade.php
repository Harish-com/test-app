<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link  {{ (request()->is('categories')) ? '' : 'collapsed' }}" href="{{ route('categories.index') }}">
                <i class="bi bi-text-indent-left"></i>
                <span>Categories </span>
            </a>
             <a class="nav-link {{ (request()->is('product')) ? '' : 'collapsed' }}" href="{{ route('product.index') }}">
                 <i class="bi bi-text-indent-left"></i>
                <span>Product </span>
            </a>
             <a class="nav-link {{ (request()->is('product-list')) ? '' : 'collapsed' }}" href="{{ route('product-list') }}">
               <i class="bi bi-text-indent-left"></i>
                <span>Product Listing</span>
            </a>
        </li>



    </ul>

</aside>
