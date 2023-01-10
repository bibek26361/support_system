  <div class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
          <ul class="nav" id="side-menu">
              <li>
                  <a href="{{ url('/') }}"><i class="fa fa-dashboard fa-fw">
                      </i> Dashboard</a>
              </li>
              <li>
                  <a href="#">
                      <i class="fa fa-cogs"></i> Notification Management
                      <span class="fa arrow"></span>
                  </a>
                  <ul class="nav nav-second-level collapse">
                      @can('view-device-token')
                          <li>
                              <a href="{{ route('notifications.getDeviceTokens') }}">
                                  <i class="fa fa-mobile" style="font-size: 20px"></i> Device Tokens
                              </a>
                          </li>
                      @endcan
                      <li>
                          <a href="{{ route('notifications.index') }}">
                              <i class="fa fa-bell"></i> Notifications
                          </a>
                      </li>
                  </ul>
              </li>
              <li>
                  <a href="#"><i class="fa fa-users"></i> Manage Users<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                      <li>
                          <a href="{{ route('department.index') }}"> <i class="fa fa-building"></i> Departments</a>
                      </li>
                      <li>
                          <a href="{{ route('user.index') }}"> <i class="fa fa-user"></i> Manage User</a>
                      </li>
                  </ul>
              </li>
              <li>
                  <a href="#"><i class="fa fa-th"></i> Product Management<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                      <li>
                          <a href="{{ route('producttypes.index') }}"> <i class="fa fa-th-list"></i> Product
                              Types</a>
                      </li>
                      <li>
                          <a href="{{ route('products.index') }}"> <i class="fa fa-box"></i> Products</a>
                      </li>
                  </ul>
              </li>
              <li>
                  <a href="#"><i class="fa fa-building"></i> Manage Organization<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                      <li>
                          <a href="{{ route('organizationtype.index') }}"> <i class="fa fa-building"></i> Organization
                              Type</a>
                      </li>
                      <li>
                          <a href="{{ route('organization.index') }}"> <i class="fa fa-school"></i> Organization</a>
                      </li>
                  </ul>
              </li>
              <li>
                  <a href="#"><i class="fa fa-exclamation"></i> Manage Problem<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                      <li>
                          <a href="{{ route('problemtype.index') }}"> <i class="fa fa-ticket"></i> Problem Type</a>
                      </li>
                      <li>
                          <a href="{{ route('problemcategory.index') }}"> <i class="fa fa-ticket"></i> Problem
                              Category</a>
                      </li>
                  </ul>
              </li>
              <li>
                  <a href="#"><i class="fa fa-list"></i> Task Management<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                      <li>
                          <a href="{{ route('task.create') }}"> <i class="fa fa-plus-circle"></i> Create New
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('tasks.new') }}"> <i class="fa fa-badge"></i> New
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('tasks.inprogress') }}" class="text-warning"> <i
                                  class="fa fa-check-circle"></i> In-Progress
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('tasks.completed') }}" class="text-success"> <i
                                  class="fa fa-badge-check"></i> Completed
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('task.index') }}"><i class="fas fa-eye"></i>
                              All</a>
                      </li>
                  </ul>
              </li>
              <li>
                  <a href="#"><i class="fa fa-ticket"></i> Ticket Management<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                      <li>
                          <a href="{{ route('ticket.create') }}"> <i class="fa fa-plus-circle"></i> Create New
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('tickets.opened') }}" class="text-success"><i
                                  class="fa fa-check-circle"></i>
                              Opened
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('tickets.assigned') }}" class="text-warning"> <i class="fa fa-th-list"></i>
                              Assigned To Me
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('tickets.transfered') }}"> <i class="fa fa-rocket"></i>
                              Transfered
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('tickets.closed') }}" class="text-danger"> <i
                                  class="fa fa-badge-check"></i> Closed
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('ticket.index') }}"> <i class="fa fa-ticket"></i> All
                          </a>
                      </li>
                  </ul>
              </li>
              <li>
                  <a href="{{ route('surveys.index') }}"><i class="fas fa-eye"></i>
                      Manage Survey</a>
              </li>
              <li>
                  <a href="#"><i class="fa fa-chart-bar"></i> Reports<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                      <li>
                          <a href="{{ route('log.system') }}"> <i class="fa fa-laptop"></i> System Log</a>
                      </li>
                      <li>
                          <a href="{{ route('log.organization') }}"> <i class="fa fa-building"></i>
                              Organization Log</a>
                      </li>
                  </ul>
              </li>
          </ul>
      </div>
  </div>
  </nav>
