<div class="sidebar sidebar-expanded fixed z-50 overflow-hidden h-screen bg-white border-r border-[#F7E6CA] flex flex-col">
            <div class="h-16 border-b border-[#F7E6CA] flex items-center px-2 space-x-2">
                <h1 class="text-xl font-bold text-black bg-[#D9D9D9] p-2 rounded-xl">LOGO</h1>
                <h1 class="text-xl font-bold text-[#4E3B2A]">HR 3&4</h1>
                <!--Close Button-->
                <i id="close-sidebar-btn" class="fa-solid fa-x close-sidebar-btn transform translate-x-20 font-bold text-xl"></i>
            </div>
            <div class="side-menu px-4 py-6">
                 <ul class="space-y-4">
                    <!-- Dashboard Item -->
                   <div class="menu-option">
                        <a href="" class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-house text-lg pr-4"></i>
                                <span class="text-sm font-medium">Dashboard</span>
                            </div>
                        
                        </a>
                    </div>
                    <div class="menu-option">
                        <a href="admin/index.php" class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-house text-lg pr-4"></i>
                                <span class="text-sm font-medium">ADMIN</span>
                            </div>
                        
                        </a>
                    </div>


                    <!-- Disbursement Item  -->
                    <div class="menu-option">
                        <div class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer" onclick="toggleDropdown('disbursement-dropdown', this)">
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-wallet text-lg pr-4"></i>
                                <span class="text-sm font-medium">Leave Management</span>
                            </div>
                            <div class="arrow">
                                <i class="bx bx-chevron-right text-[18px] font-semibold arrow-icon"></i>
                            </div>
                        </div>

                        
                     <!-- Disbursement Item  -->

                        <div id="disbursement-dropdown" class="menu-drop hidden flex-col w-full bg-[#F7E6CA] rounded-lg p-4 space-y-2 mt-2">
                        <div class="menu-option">
<!-- Disbursement Item  -->
                        <div class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer" onclick="window.location.href='apply.php'">
                            <div class="flex items-center space-x-2">  
                                <a href="apply.php">                              
                                <span  href="apply.php" class="text-sm font-medium">Apply Leave</span>
</a>
                            </div>
                           
                        </div>
                        <div class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer" onclick="window.location.href='leavebalance.php'">
                            <div class="flex items-center space-x-2">  
                                <a href="leavebalance.php">                              
                                <span   class="text-sm font-medium">Leave Balance</span>
</a>
                            </div>
                            
                        </div>
                        <div class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer" onclick="window.location.href='leavetype.php'">
                            <div class="flex items-center space-x-2">  
                                <a href="leavetype.php">                              
                                <span   class="text-sm font-medium">Leave Types</span>
</a>
                            </div>
                            
                        </div>
                      
                   
<!-- Disbursement Item  -->
                        </div>
                        </div>
                     <!-- Disbursement Item  -->

                    </div>

                    
                </ul>
            </div>
        </div>