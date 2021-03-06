<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar Menu -->


    {{-- ASSOCIAZIONE --}}
    <ul class="sidebar-menu" data-widget="tree">      
      
      @if(Auth::user()->hasRole('admin'))

        <li class="treeview @if (in_array('associazioni',Request::segments())) active @endif">
          <a href="#"><i class="fa fa-users"></i> <span>Associazioni</span>
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
          <a href="#"><i class="fa fa-user"></i> <span>Volontari</span>
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
          <a href="#"><i class="fa fa-bullhorn"></i> <span>Posts</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('posts.index') }}">Elenco</a></li>
            <li><a href="{{ route('posts.create') }}">Nuovo</a></li>
          </ul>
        </li>

        {{-- FILE UPLOAD --}}
        <li class="treeview @if (in_array('documenti',Request::segments())) active @endif">
          <a href="#"><i class="fa fa-folder-open-o"></i> <span>Documenti</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('documenti.index') }}">Elenco</a></li>
            <li><a href="{{ route('documenti.form-upload') }}">Nuovo</a></li>
          </ul>
        </li>

      @endif

      {{-- PREVENTIVI --}}
      <li class="treeview @if (in_array('preventivi',Request::segments())) active @endif">
        <a href="#"><i class="fa fa-send-o"></i> <span>Preventivi</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('preventivi.index') }}">Elenco</a></li>
          
          @if (!Auth::user()->hasRole(['GGV Semplice','Polizia']))
            <li><a href="{{ route('preventivi.create') }}">Nuovo</a></li>
          @endif  
        
        </ul>
      </li>

      {{-- RELAZIONI --}}
      <li class="treeview @if (in_array('relazioni',Request::segments())) active @endif">
        <a href="#"><i class="fa fa-envelope-o"></i> <span>Relazioni</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('relazioni.index') }}">Elenco</a></li>
        </ul>
      </li>

      {{-- DOCUMENTI ELENCO --}}
      @if(Auth::user()->hasRole('associazione'))
      <li class="treeview @if (in_array('documenti',Request::segments())) active @endif">
        <a href="#"><i class="fa fa-folder-open-o"></i> <span>Documenti</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('documenti.index') }}">Elenco</a></li>
        </ul>
      </li>
      @endif
      
      @if(Auth::user()->hasRole('admin'))
        <li class="header">&nbsp;</li>
        <li><a href="{{ route('utenti') }}"><i class="fa fa-navicon text-aqua"></i> <span>Elenco admin</span></a></li>
        <li><a href="{{ route('register') }}"><i class="fa fa-plus-square text-aqua"></i> <span>Registra nuovo admin</span></a></li>

      @endif
      

    </ul>
    <!-- /.sidebar-menu -->


    
  </section>
  <!-- /.sidebar -->
</aside>