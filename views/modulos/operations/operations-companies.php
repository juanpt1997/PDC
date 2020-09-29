<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Companies</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Companies</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"></h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table tablaCompanies table-sm">
                            <thead>
                                <tr>
                                    <th>Country</th>
                                    <th>Company</th>
                                    <th>ID</th>
                                    <th>Address Line1</th>
                                    <th>Address Line2</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>ZIP Code</th>
                                    <th>Contact</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Actions</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>United States</td>
                                    <td>Jacks Egg Farm</td>
                                    <td>10001</td>
                                    <td>130 44th St</td>
                                    <td>Apartment 3</td>
                                    <td>Brooklyn</td>
                                    <td>NY</td>
                                    <td>11232</td>
                                    <td>Evelyn Loor Gonzalez</td>
                                    <td>(718)5670725</td>
                                    <td>evelyn@jackseggfarm.com</td>
                                    <td><a class="btn btn-info btn-sm" href="#"><i class="fas fa-pencil-alt"></i></a></td>
                                </tr>

                                <tr>
                                    <td>United States</td>
                                    <td>Nightingale Bakery</td>
                                    <td>10002</td>
                                    <td>275 Broad St</td>
                                    <td>Apartament 1</td>
                                    <td>Carlstad</td>
                                    <td>NJ</td>
                                    <td>07022</td>
                                    <td>Evelyn Kotzias</td>
                                    <td>12232332</td>
                                    <td>nightingalebakery@gmail.com</td>
                                    <td><a class="btn btn-info btn-sm" href="#"><i class="fas fa-pencil-alt"></i></a></td>
                                </tr>

                                <tr>
                                    <td>United States</td>
                                    <td>Victory Foodservice</td>
                                    <td>10003</td>
                                    <td>515 Truxton Street</td>
                                    <td>Apartment 2</td>
                                    <td>Bronx</td>
                                    <td>NY</td>
                                    <td>10474</td>
                                    <td>Mike Rubinstein</td>
                                    <td>(718)3781122</td>
                                    <td>mrubinstein@victoryfoodservice.com</td>
                                    <td><a class="btn btn-info btn-sm" href="#"><i class="fas fa-pencil-alt"></i></a></td>

                                </tr>

                            </tbody>
                        </table>
                    </div>



                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">

                    <button type="button" class="btn btn-primary btn-sm btn-primary float-left" data-toggle="modal" data-target="#modal-newcompany">New Company</button>

                </div>

            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- ===================================================
    BEGIN MODALS
=================================================== -->
<div class="modal fade" id="modal-newcompany">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New Company</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p align="center">form here</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->