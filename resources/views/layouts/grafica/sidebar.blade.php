<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar Menu -->


    {{-- ASSOCIAZIONE --}}
    <ul class="sidebar-menu" data-widget="tree">      
      
      @if(Auth::user()->hasRole('admin'))

        <li class="treeview @if (in_array('associazioni',Request::segments())) active @endif">
          <a href="#"><i class="fa fa-link"></i> <span>Associazioni</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('associazioni.index') }}">Elenco</a></li>
            <li><a href="{{ route('associazioni.create') }}">Nuova</a></li>
          </ul>
        </li>

      {{-- VOLONTARI --}}
        <li class="treeview @if (in_array('volontari',Request::segments())) active @endif">
          <a href="#"><i class="fa fa-link"></i> <span>Volontari</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('volontari.index') }}">Elenco</a></li>
            <li><a href="{{ route('volontari.create') }}">Nuovo</a></li>
          </ul>
        </li>


        {{-- POSTS --}}
        <li class="treeview @if (in_array('posts',Request::segments())) active @endif">
          <a href="#"><i class="fa fa-link"></i> <span>Posts</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('posts.index') }}">Elenco</a></li>
            <li><a href="{{ route('posts.create') }}">Nuovo</a></li>
          </ul>
        </li>
      @endif
      
      {{-- PREVENTIVI --}}
      <li class="treeview @if (in_array('preventivi',Request::segments())) active @endif">
        <a href="#"><i class="fa fa-link"></i> <span>Preventivi</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('preventivi.index') }}">Elenco</a></li>
          <li><a href="{{ route('preventivi.create') }}">Nuovo</a></li>
        </ul>
      </li>

      {{-- RELAZIONI --}}
      <li class="treeview @if (in_array('relazioni',Request::segments())) active @endif">
        <a href="#"><i class="fa fa-link"></i> <span>Relazioni</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('relazioni.index') }}">Elenco</a></li>
        </ul>
      </li>
    </ul>
    <!-- /.sidebar-menu -->


    
  </section>
  <!-- /.sidebar -->
</aside>