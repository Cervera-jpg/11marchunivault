@extends('layouts.user_type.auth')

@section('content')
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    <div class="container-fluid">
      <!-- Profile Header Section -->
      <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
      </div>

      <!-- Main Profile Card -->
      <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <!-- Profile content will go here -->
        </div>
      </div>
    </div>

    <div class="container-fluid py-4">
      <div class="row">
        <!-- Left Column -->
        <div class="col-12 col-xl-4">
          <div class="card h-100">
            <!-- Settings content will go here -->
          </div>
        </div>

        <!-- Middle Column -->
        <div class="col-12 col-xl-4">
          <div class="card h-100">
            <!-- Profile information will go here -->
          </div>
        </div>

        <!-- Right Column -->
        <div class="col-12 col-xl-4">
          <div class="card h-100">
            <!-- Conversations will go here -->
          </div>
        </div>

        <!-- Projects Section -->
        <div class="col-12 mt-4">
          <div class="card mb-4">
            <!-- Projects content will go here -->
          </div>
        </div>
      </div>

      @include('layouts.footers.auth.footer')
    </div>
  </div>
@endsection

