
        <!-- Main Content -->
       <div class="container-fluid">

         
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
         </div>

         
         <div class="row">

           
           <div class="col-xl-3 col-md-6 mb-4">
             <div class="card border-left-primary shadow h-100 py-2">
               <div class="card-body">
                 <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Departments</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $display['c_department']; ?> Departments</div>
                   </div>
                   <div class="col-auto">
                     <i class="fas fa-building fa-2x text-gray-300"></i>
                   </div>
                 </div>
               </div>
             </div>
           </div>

           <div class="col-xl-3 col-md-6 mb-4">
             <div class="card border-left-success shadow h-100 py-2">
               <div class="card-body">
                 <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Employees</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $display['c_employee']; ?> Employees</div>
                   </div>
                   <div class="col-auto">
                     <i class="fas fa-id-badge fa-2x text-gray-300"></i>
                   </div>
                 </div>
               </div>
             </div>
           </div>

           <div class="col-xl-3 col-md-6 mb-4">
             <div class="card border-left-danger shadow h-100 py-2">
               <div class="card-body">
                 <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Users</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $display['c_users']; ?> Active Users</div>
                   </div>
                   <div class="col-auto">
                     <i class="fas fa-users fa-2x text-gray-300"></i>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>


         <div class="row">

           <div class="col-xl-4 col-lg-5">
             <div class="col p-0">
               <div class="card shadow mb-4">
                 <div class="card-header py-3 d-flex flex-rowz align-items-center justify-content-between">
                   <h6 class="m-0 font-weight-bold text-primary">Departments' Employees</h6>
                   <div class="dropdown no-arrow">
                     <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                       <div class="dropdown-header">More Details:</div>
                       <a class="dropdown-item" href="admin">Department List</a>
                     </div>
                   </div>
                 </div>
                 <div class="card-body" style="max-height: 400px; overflow: scroll; overflow-x : hidden;">
                   <table class="table">
                     <thead class="bg-info text-white">
                       <tr>
                         <th scope="col">#</th>
                         <th scope="col">Dept Code</th>
                         <th scope="col">Department</th>
                       </tr>
                     </thead>
                     <tbody>
                     
                     <?php  $i = 1; foreach ($items as $item): ?>
                                <tr>
                                    <td> <?= $i++; ?> </td>
                                    <td> <?php echo $item['id']; ?> </td>
                                    <td> <?php echo $item['name']; ?> </td>
                                </tr>	
                            <?php endforeach; ?>
                     </tbody>
                   </table>
                 </div>
               </div>
             </div>
           </div>
          </div>
         </div>
        </div>
       <!-- End of Main Content -->
      