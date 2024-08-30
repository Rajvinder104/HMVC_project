<?php require_once('header.php')?>
<section id="main" class="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 page-title">
                <h3>Only Table</h3>
            </div>
        </div>
    </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <!-- table-search-bar -->
                    <div class="main-table-div">
                        <div class="table-searhbar">
                            <form>
                                <div class="forn-flex-div">
                                    <select class="form-select" name="selval">
                                        <option value="1" selected>Name</option>
                                        <option value="2">User Id</option>
                                        <option value="3">Phone</option>
                                        <option value="3">Sponser Id</option>
                                    </select>
                                    <input type="text" placeholder="Search" name="Search">
                                    <button type="submit" class="btn srh-btn"><i
                                        class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- table -->
                        <div class="admin-table">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>TXN Pin</th>
                                        <th>Sponsor ID</th>
                                        <th>Package</th>
                                        <th>Total Investment</th>
                                        <th>E-wallet</th>
                                        <th>Directs</th>
                                        <th>Income</th>
                                        <th>Joining Date</th>
                                        <th class="th-action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>0231</td>
                                        <td>Amandeep singh</td>
                                        <td>9646261612</td>
                                        <td>amandeepwarwal55@gmail.com</td>
                                        <td>993435</td>
                                        <td>894622</td>
                                        <td>WR-894622</td>
                                        <td>14000</td>
                                        <td>14000</td>
                                        <td>0.014</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>22-07-2023</td>
                                        <td class="td-action">
                                            <a href="#" class="login-btn">Login</a>
                                            <a href="#" class="edit-btn">Edit</a>
                                            <a href="#" class="block-btn">Block</a>
                                        </td>
                                    </tr>
                               
                                   
                                </tbody>
                            </table>    
                        </div> 
                        <!-- pagination -->
                        <div class="table-pagination">
                            <nav>
                                <ul class="pagination" >
                                  <li class="page-item"><a class="page-link previous" href="#"><i class="fa-solid fa-backward"></i></a></li>
                                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                                  <li class="page-item"><a class="page-link next" href="#"><i class="fa-solid fa-forward"></i></a></li>
                                </ul>
                              </nav>
                        </div>

                    </div>
                </div> 
            </div>
        </div>
       



</section>


<?php require_once('footer.php')?>