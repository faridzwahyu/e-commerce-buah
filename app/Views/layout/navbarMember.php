<nav class="navbar navbar-expand-lg navbar-light bg-light">
   <div class="container">
      <a class="navbar-brand" href="">Project 2.0</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav">
            <li class="nav-item">
               <a class="nav-link active" href="/home">Home</a>
            </li>                           
            <li class="nav-item">
               <a class="nav-link" href="/profile">Profile</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/auth/logout" onclick="return confirm('Are you sure to logout?');">Logout</a>
            </li>               
         </ul>
      </div>
   </div>
</nav>