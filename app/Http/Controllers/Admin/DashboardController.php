<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BeritaService;
use App\Services\GerejaService;
use App\Services\Periodik\PerBulanService;
use App\Services\Periodik\PerSemesterService;
use App\Services\Periodik\PerTahunService;
use App\Services\SekolahService;
use App\Services\UserService;

class DashboardController extends Controller
{
  public function index()
  {
    return view('pages.admin.dashboard');
  }
}
