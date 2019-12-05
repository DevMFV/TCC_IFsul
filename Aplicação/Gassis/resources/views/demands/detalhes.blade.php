<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>GAssis</title>

   <!-- Font-family Montserrat -->
   <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="{{asset('vendor-sbAdmin/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="{{asset('vendor-sbAdmin/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('css-sbAdmin/sb-admin.css')}}" rel="stylesheet">


  <style>
    .container-file-iten{

      @if($demands->filename!=null && $extensao!="zip")

        background-image:url({!!$demands->filename!!});
        background-repeat: no-repeat;
        background-size: cover;
        background-position-y: center;
        background-position-x: center;

      @elseif($extensao=="zip")

        background-image:url('storage/comprimido.png');
        background-position-y: center;
        background-position-x: center;
        background-repeat: no-repeat;
        background-size: 35%;

      @else

        background-image:url('storage/no-file.png');
        background-position-y: center;
        background-position-x: center;
        background-repeat: no-repeat;
        
      @endif

      
    }
  </style>

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="#">GAssis</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <!-- <i class="fas fa-bars"></i> -->
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">

      <div class="dv">.</div>

      <li class="nav-item">
        <a class="nav-link" href="{{route('user.logout')}}">
          <span class="logout">Sair</span>
        </a>
      </li>

      <!--
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger">9+</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
      -->

    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
     
     <li class="nav-item">
       <a class="nav-link" href="{{route('dashboard')}}">
         <i class="fas fa-fw fa-tachometer-alt"></i>
         <span>Página inicial</span>
       </a>
     </li>

     @if (Gate::allows('admOrReq'))
     <li class="nav-item active">
       <a class="nav-link" href="{{route('demand.index')}}">
         <i class="fas fa-fw fa-clock"></i>
         <span>Demandas</span></a>

         <li class="nav-item active" style="margin-left: 15%; padding:0">
            <a class="nav-link" href="{{route('demand.index')}}">
              <span>Ativas</span>
            </a>
          </li>

          <li class="nav-item" style="margin-left: 15%; padding:0">
            <a class="nav-link" href="{{route('demandRemoved')}}">
              <span>Removidas</span>
            </a>
          </li>
      
     </li>
     @endif


     @if (Gate::allows('admOrProd'))
     <li class="nav-item">
       <a class="nav-link" href="{{route('production.index')}}">
         <i class="fas fa-fw fa-box"></i>
         <span>Produções</span></a>
     </li>
     @endif

     <li class="nav-item">
       <a class="nav-link" href="{{route('assisted.index')}}">
         <i class="fas fa-fw fa-hands"></i>
         <span>Assistidos</span></a>
     </li>

     @if (Gate::allows('admin'))
     <li class="nav-item">
       <a class="nav-link" href="{{route('requester.index')}}">
         <i class="fas fa-fw fa-user"></i>
         <span>Solicitantes</span></a>
     </li>
     
     <li class="nav-item">
       <a class="nav-link" href="{{route('productor.index')}}">
         <i class="fas fa-fw fa-hammer"></i>
         <span>Produtores</span></a>
     </li>

     <li class="nav-item">
       <a class="nav-link" href="{{route('tipoSol.index')}}">
         <i class="fas fa-fw fa-list"></i>
         <span>Tipo de Solicitante</span></a>
     </li>
     @endif

</ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Menu</a>
          </li>
          <li class="breadcrumb-item active">Demandas</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">

        @foreach($anexos as $anexo)
          <div style="background-color:red">{!!$anexo->file!!}</div>
        @endforeach



          <div class="card-header">
            <i class="fas fa-search"></i>
            Detalhes</div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="container-details">
                <div class="datas-details" style="display: flex;flex-direction: column; justify-content:center; align-items:center">
                  
                  <div class="data-item" style=" width:95%; height:91%; justify-content:space-evenly;">
                    
                    <span  class="form-legend-detail">Título</span>
                    
                    <div class="container-data">
                      <span  class="form-data-detail">
                        {!!$demands->titulo!!}
                      </span>
                    </div>

                    <span class="form-legend-detail">Solicitante</span>

                    @foreach($demands->anexos() as $anexo)
                     <div style="background-color:red">{!!$anexo!!}</div>
                    @endforeach
                    
                    <div class="container-data">
                      <span class="form-data-detail">
                        {!!$demands->requester->name!!}
                      </span>
                    </div>

                    <span class="form-legend-detail">Assistido</span>
                    
                    <div class="container-data">
                      <span class="form-data-detail">
                        {!!$demands->assisted->name!!}
                      </span>
                    </div>

                    <span class="form-legend-detail">Data do pedido</span>
                    
                    <div class="container-data">
                      <span class="form-data-detail">
                        <?php echo date("d/m/Y", strtotime($demands->created_at)); ?>
                      </span>
                    </div>

                    <span class="form-legend-detail">Data prazo</span>
                    
                    <div class="container-data">
                      <span class="form-data-detail">
                        <?php echo date("d/m/Y", strtotime($demands->data_prazo)); ?>
                      </span>
                    </div>

                  </div>
                    


                <!-- datas-details -->
                </div>
                <div class="datas-details" 
                     style="display: flex;
                           flex-direction: column;
                           justify-content: center;"
                >
                    {!!$demands->descricao!!}
                    <div class="container-file">
                      <div id="container-file-iten" class="container-file-iten">

                     

                      @if($extensao=="pdf")
                        <iframe src="{{url($demands->filename)}}" style="width:100%;heigth:100%;border:none"></iframe>
                      @else
                        <img id="img" class="img-teste">
                      @endif

                      <!-- container-file-iten -->  
                      </div>
                      <div class="container-file-iten-2">
                        <a class="nav-link" href="{{route('productor.index')}}">
                          <i class="fas fa-fw fa-expand"></i>
                        </a>
                        <a class="nav-link" href="{{route('productor.index')}}">
                          <i class="fas fa-fw fa-download"></i>
                        </a>
                        <span style="font-family: Montserrat;position: relative;left: 65%;line-height: 244%;" class="form-legend">{!!$nomeArquivo!!}</span>
                      <!-- container-file-iten-2  -->
                      <div>
                    <!-- container-file -->
                    </div>
                <!-- datas-details -->
                </div>
              <!-- container-details -->
              </div> 
            </div>
          </div>
          <div class="nav-link-topAction-back-div">
                <a class="nav-link-topAction-back" href="{{route('demand.index')}}">
                  Voltar
                </a>
              </div>

          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

        <p class="small text-center text-muted my-5">
          <em>More table examples coming soon...</em>
        </p>

      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
