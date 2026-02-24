<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center gap-2 pt-8 sidebar-header pb-7"
  >
    <a href="@if(Auth::guard('admin')->check()){{ route('admin') }}@elseif(Auth::check() && Auth::user()->role === 'teacher'){{ route('teacher.dashboard') }}@else{{ route('student.dashboard') }}@endif" class="flex items-center gap-2.5">
      <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white font-bold text-base shadow-md">
        S
      </div>
      <span :class="sidebarToggle ? 'hidden' : 'block'" class="text-lg font-bold text-gray-900 dark:text-white">
        StudentHub
      </span>
    </a>
  </div>
  <!-- SIDEBAR HEADER -->

  <div
    class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar"
  >
    <!-- Sidebar Menu -->
    <nav x-data="{selected: $persist('Dashboard')}">
      <!-- Menu Group -->
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span
            class="menu-group-title"
            :class="sidebarToggle ? 'lg:hidden' : ''"
          >
            MENU
          </span>

          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
              fill=""
            />
          </svg>
        </h3>

        @php
          $isAdmin = Auth::guard('admin')->check();
          $webUser = Auth::user();
          $role = $webUser?->role;

          $dashboardRoute = $isAdmin
              ? 'admin'
              : match ($role) {
                  'teacher' => 'teacher.dashboard',
                  'student' => 'student.dashboard',
                  default => 'home',
              };

          $profileRoute = $isAdmin
              ? 'admin.profile'
              : match ($role) {
                  'teacher' => 'teacher.profile',
                  'student' => 'student.profile',
                  default => 'home',
              };
        @endphp

        <ul class="flex flex-col gap-4 mb-6">
          <!-- Menu Item Dashboard -->
          <li>
            <a
              href="{{ route($dashboardRoute) }}"
              class="menu-item group"
              :class=" (selected === 'Dashboard') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Dashboard') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Dashboard
              </span>

              
            </a>

            <!-- Dropdown Menu Start -->
            <div
              class="overflow-hidden transform translate"
              :class="(selected === 'Dashboard') ? 'block' :'hidden'"
            >
              
            </div>
            <!-- Dropdown Menu End -->
          </li>
          <!-- Menu Item Dashboard -->

          {{-- ========== ADMIN ONLY MENU ITEMS ========== --}}
          @if ($isAdmin)
          <!-- Menu Item user Management -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Students' ? '':'Students')"
              class="menu-item group"
              :class="(selected === 'Students' || selected == 'Teachers') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Students' || selected == 'Teachers') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 14.1526 4.3002 16.1184 5.61936 17.616C6.17279 15.3096 8.24852 13.5955 10.7246 13.5955H13.2746C15.7509 13.5955 17.8268 15.31 18.38 17.6167C19.6996 16.119 20.5 14.153 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM17.0246 18.8566V18.8455C17.0246 16.7744 15.3457 15.0955 13.2746 15.0955H10.7246C8.65354 15.0955 6.97461 16.7744 6.97461 18.8455V18.856C8.38223 19.8895 10.1198 20.5 12 20.5C13.8798 20.5 15.6171 19.8898 17.0246 18.8566ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9991 7.25C10.8847 7.25 9.98126 8.15342 9.98126 9.26784C9.98126 10.3823 10.8847 11.2857 11.9991 11.2857C13.1135 11.2857 14.0169 10.3823 14.0169 9.26784C14.0169 8.15342 13.1135 7.25 11.9991 7.25ZM8.48126 9.26784C8.48126 7.32499 10.0563 5.75 11.9991 5.75C13.9419 5.75 15.5169 7.32499 15.5169 9.26784C15.5169 11.2107 13.9419 12.7857 11.9991 12.7857C10.0563 12.7857 8.48126 11.2107 8.48126 9.26784Z"
                  fill=""
                />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">User Management</span>
              <svg
                class="menu-item-arrow"
                :class="[(selected === 'Students' || selected === 'Teachers') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <div class="overflow-hidden transform translate" :class="(selected === 'Students' || selected === 'Teachers') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                <li><a href="{{ route('admin.teachers.index') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.teachers') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Teachers</a></li>
                <li><a href="{{ route('admin.students.index') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.students') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Students</a></li>
              </ul>
            </div>
          </li>
          <!-- Menu Item Students -->

          <!-- Menu Item Academic Management -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Academic' ? '':'Academic')"
              class="menu-item group"
              :class="(selected === 'Academic') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Academic') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M12 2.25C12.1989 2.25 12.3897 2.32902 12.5303 2.46967L21.5303 11.4697C21.8232 11.7626 21.8232 12.2374 21.5303 12.5303C21.2374 12.8232 20.7626 12.8232 20.4697 12.5303L20 12.0607V19C20 20.1046 19.1046 21 18 21H6C4.89543 21 4 20.1046 4 19V12.0607L3.53033 12.5303C3.23744 12.8232 2.76256 12.8232 2.46967 12.5303C2.17678 12.2374 2.17678 11.7626 2.46967 11.4697L11.4697 2.46967C11.6103 2.32902 11.8011 2.25 12 2.25ZM5.5 10.5607V19C5.5 19.2761 5.72386 19.5 6 19.5H18C18.2761 19.5 18.5 19.2761 18.5 19V10.5607L12 4.06066L5.5 10.5607Z"
                  fill=""
                />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Academic</span>
              <svg
                class="menu-item-arrow"
                :class="[(selected === 'Academic') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <div class="overflow-hidden transform translate" :class="(selected === 'Academic') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                <li><a href="{{ route('admin.classes.index') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.classes.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Classes</a></li>
                <li><a href="{{ route('admin.sections.index') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.sections.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Sections</a></li>
                <li><a href="{{ route('admin.subjects.index') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.subjects.*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Subjects</a></li>
              </ul>
            </div>
          </li>
          <!-- Menu Item Academic Management -->

          <!-- Menu Item Attendance -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'AdminAttendance' ? '':'AdminAttendance')"
              class="menu-item group"
              :class="(selected === 'AdminAttendance') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'AdminAttendance') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM8 5.25H5.5C5.08579 5.25 4.75 5.58579 4.75 6V8.25H19.25V6C19.25 5.58579 18.9142 5.25 18.5 5.25H16H8ZM19.25 9.75H4.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75Z"
                  fill=""
                />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Attendance</span>
              <svg
                class="menu-item-arrow"
                :class="[(selected === 'AdminAttendance') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <div class="overflow-hidden transform translate" :class="(selected === 'AdminAttendance') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                <li><a href="{{ route('admin.attendance.index') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.attendance.index') || request()->routeIs('admin.attendance.show') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">View Attendance</a></li>
                <li><a href="{{ route('admin.attendance.create') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.attendance.create') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Mark Attendance</a></li>
                <li><a href="{{ route('admin.attendance.report') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.attendance.report') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Monthly Reports</a></li>
              </ul>
            </div>
          </li>
          <!-- Menu Item Attendance -->

          <!-- Menu Item Examination -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Examination' ? '':'Examination')"
              class="menu-item group"
              :class="(selected === 'Examination') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Examination') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z"
                  fill=""
                />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Examination</span>
              <svg
                class="menu-item-arrow"
                :class="[(selected === 'Examination') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <div class="overflow-hidden transform translate" :class="(selected === 'Examination') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                <li><a href="{{ route('admin.examinations.index') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.examinations.index') || request()->routeIs('admin.examinations.show') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">View Exams</a></li>
                <li><a href="{{ route('admin.examinations.create') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.examinations.create') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Create Exam</a></li>
              </ul>
            </div>
          </li>
          <!-- Menu Item Examination -->

          <!-- Menu Item Fees -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Fees' ? '':'Fees')"
              class="menu-item group"
              :class="(selected === 'Fees') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Fees') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M12 2C12.4142 2 12.75 2.33579 12.75 2.75V4.03078C15.5686 4.37932 17.75 6.81126 17.75 9.75V10.25C17.75 10.6642 17.4142 11 17 11C16.5858 11 16.25 10.6642 16.25 10.25V9.75C16.25 7.40279 14.3472 5.5 12 5.5C9.65279 5.5 7.75 7.40279 7.75 9.75V14.25C7.75 16.5972 9.65279 18.5 12 18.5C14.3472 18.5 16.25 16.5972 16.25 14.25V13.75C16.25 13.3358 16.5858 13 17 13C17.4142 13 17.75 13.3358 17.75 13.75V14.25C17.75 17.1887 15.5686 19.6207 12.75 19.9692V21.25C12.75 21.6642 12.4142 22 12 22C11.5858 22 11.25 21.6642 11.25 21.25V19.9692C8.43139 19.6207 6.25 17.1887 6.25 14.25V9.75C6.25 6.81126 8.43139 4.37932 11.25 4.03078V2.75C11.25 2.33579 11.5858 2 12 2Z"
                  fill=""
                />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Fees</span>
              <svg
                class="menu-item-arrow"
                :class="[(selected === 'Fees') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <div class="overflow-hidden transform translate" :class="(selected === 'Fees') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                <li><a href="{{ route('admin.fees.index') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.fees.index') || request()->routeIs('admin.fees.show') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">View Fees</a></li>
                <li><a href="{{ route('admin.fees.create') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.fees.create') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Add Fee</a></li>
              </ul>
            </div>
          </li>
          <!-- Menu Item Fees -->

          <!-- Menu Item Notifications -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Notifications' ? '':'Notifications')"
              class="menu-item group"
              :class="(selected === 'Notifications') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Notifications') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M12 2C8.68629 2 6 4.68629 6 8V9.58579L4.29289 11.2929C4.10536 11.4804 4 11.7348 4 12V15C4 15.5523 4.44772 16 5 16H8.17071C8.58254 17.1652 9.69378 18 11 18H13C14.3062 18 15.4175 17.1652 15.8293 16H19C19.5523 16 20 15.5523 20 15V12C20 11.7348 19.8946 11.4804 19.7071 11.2929L18 9.58579V8C18 4.68629 15.3137 2 12 2ZM14 16H10C9.44772 16 9 15.5523 9 15V14H15V15C15 15.5523 14.5523 16 14 16ZM16 12V8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8V12L6.41421 13.5858L6 14H18L17.5858 13.5858L16 12ZM12 20C10.8954 20 10 20.8954 10 22H14C14 20.8954 13.1046 20 12 20Z"
                  fill=""
                />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Notifications</span>
              <svg
                class="menu-item-arrow"
                :class="[(selected === 'Notifications') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <div class="overflow-hidden transform translate" :class="(selected === 'Notifications') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                <li><a href="{{ route('admin.notifications.index') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.notifications.index') || request()->routeIs('admin.notifications.show') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">View Notifications</a></li>
                <li><a href="{{ route('admin.notifications.create') }}" class="menu-dropdown-item group {{ request()->routeIs('admin.notifications.create') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Send Notification</a></li>
              </ul>
            </div>
          </li>
          <!-- Menu Item Notifications -->
          @endif
          {{-- ========== END ADMIN ONLY ========== --}}

          {{-- ========== TEACHER ONLY MENU ITEMS ========== --}}
          @if (!$isAdmin && $role === 'teacher')

          <!-- Teacher: Attendance -->
          <li>
            <a href="#" @click.prevent="selected = (selected === 'Attendance' ? '':'Attendance')"
               class="menu-item group" :class="(selected === 'Attendance') ? 'menu-item-active' : 'menu-item-inactive'">
              <svg :class="(selected === 'Attendance') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM8 5.25H5.5C5.08579 5.25 4.75 5.58579 4.75 6V8.25H19.25V6C19.25 5.58579 18.9142 5.25 18.5 5.25H16H8ZM19.25 9.75H4.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75Z" fill=""/>
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Attendance</span>
              <svg class="menu-item-arrow" :class="[(selected === 'Attendance') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <div class="overflow-hidden transform translate" :class="(selected === 'Attendance') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                <li><a href="{{ route('teacher.attendance.index') }}" class="menu-dropdown-item group {{ request()->routeIs('teacher.attendance.index') || request()->routeIs('teacher.attendance.edit') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">View Records</a></li>
                <li><a href="{{ route('teacher.attendance.create') }}" class="menu-dropdown-item group {{ request()->routeIs('teacher.attendance.create') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Mark Attendance</a></li>
                <li><a href="{{ route('teacher.attendance.report') }}" class="menu-dropdown-item group {{ request()->routeIs('teacher.attendance.report') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Monthly Report</a></li>
              </ul>
            </div>
          </li>

          <!-- Teacher: Examination -->
          <li>
            <a href="#" @click.prevent="selected = (selected === 'TeacherExam' ? '':'TeacherExam')"
               class="menu-item group" :class="(selected === 'TeacherExam') ? 'menu-item-active' : 'menu-item-inactive'">
              <svg :class="(selected === 'TeacherExam') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z" fill=""/>
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Examination</span>
              <svg class="menu-item-arrow" :class="[(selected === 'TeacherExam') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <div class="overflow-hidden transform translate" :class="(selected === 'TeacherExam') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                <li><a href="{{ route('teacher.examinations.index') }}" class="menu-dropdown-item group {{ request()->routeIs('teacher.examinations.index') || request()->routeIs('teacher.examinations.show') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">View Exams</a></li>
                <li><a href="{{ route('teacher.examinations.create') }}" class="menu-dropdown-item group {{ request()->routeIs('teacher.examinations.create') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Schedule Exam</a></li>
              </ul>
            </div>
          </li>

          <!-- Teacher: Fee Records -->
          <li>
            <a href="{{ route('teacher.fees.index') }}"
               class="menu-item group {{ request()->routeIs('teacher.fees.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
              <svg class="{{ request()->routeIs('teacher.fees.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C12.4142 2 12.75 2.33579 12.75 2.75V4.03078C15.5686 4.37932 17.75 6.81126 17.75 9.75V10.25C17.75 10.6642 17.4142 11 17 11C16.5858 11 16.25 10.6642 16.25 10.25V9.75C16.25 7.40279 14.3472 5.5 12 5.5C9.65279 5.5 7.75 7.40279 7.75 9.75V14.25C7.75 16.5972 9.65279 18.5 12 18.5C14.3472 18.5 16.25 16.5972 16.25 14.25V13.75C16.25 13.3358 16.5858 13 17 13C17.4142 13 17.75 13.3358 17.75 13.75V14.25C17.75 17.1887 15.5686 19.6207 12.75 19.9692V21.25C12.75 21.6642 12.4142 22 12 22C11.5858 22 11.25 21.6642 11.25 21.25V19.9692C8.43139 19.6207 6.25 17.1887 6.25 14.25V9.75C6.25 6.81126 8.43139 4.37932 11.25 4.03078V2.75C11.25 2.33579 11.5858 2 12 2Z" fill=""/>
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Fee Records</span>
            </a>
          </li>

          <!-- Teacher: Notifications -->
          <li>
            <a href="#" @click.prevent="selected = (selected === 'TeacherNotif' ? '':'TeacherNotif')"
               class="menu-item group" :class="(selected === 'TeacherNotif') ? 'menu-item-active' : 'menu-item-inactive'">
              <svg :class="(selected === 'TeacherNotif') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C8.68629 2 6 4.68629 6 8V9.58579L4.29289 11.2929C4.10536 11.4804 4 11.7348 4 12V15C4 15.5523 4.44772 16 5 16H8.17071C8.58254 17.1652 9.69378 18 11 18H13C14.3062 18 15.4175 17.1652 15.8293 16H19C19.5523 16 20 15.5523 20 15V12C20 11.7348 19.8946 11.4804 19.7071 11.2929L18 9.58579V8C18 4.68629 15.3137 2 12 2ZM14 16H10C9.44772 16 9 15.5523 9 15V14H15V15C15 15.5523 14.5523 16 14 16ZM16 12V8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8V12L6.41421 13.5858L6 14H18L17.5858 13.5858L16 12ZM12 20C10.8954 20 10 20.8954 10 22H14C14 20.8954 13.1046 20 12 20Z" fill=""/>
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Notifications</span>
              <svg class="menu-item-arrow" :class="[(selected === 'TeacherNotif') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <div class="overflow-hidden transform translate" :class="(selected === 'TeacherNotif') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                <li><a href="{{ route('teacher.notifications.index') }}" class="menu-dropdown-item group {{ request()->routeIs('teacher.notifications.index') || request()->routeIs('teacher.notifications.show') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Inbox</a></li>
                <li><a href="{{ route('teacher.notifications.create') }}" class="menu-dropdown-item group {{ request()->routeIs('teacher.notifications.create') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">Send Notice</a></li>
              </ul>
            </div>
          </li>

          @endif
          {{-- ========== END TEACHER ONLY ========== --}}

          {{-- ========== STUDENT ONLY MENU ITEMS ========== --}}
          @if (!$isAdmin && $role === 'student')

          <!-- Student: Attendance -->
          <li>
            <a href="{{ route('student.attendance.index') }}"
               class="menu-item group {{ request()->routeIs('student.attendance.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
              <svg class="{{ request()->routeIs('student.attendance.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM8 5.25H5.5C5.08579 5.25 4.75 5.58579 4.75 6V8.25H19.25V6C19.25 5.58579 18.9142 5.25 18.5 5.25H16H8ZM19.25 9.75H4.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75Z" fill=""/>
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">My Attendance</span>
            </a>
          </li>

          <!-- Student: Examinations -->
          <li>
            <a href="{{ route('student.examinations.index') }}"
               class="menu-item group {{ request()->routeIs('student.examinations.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
              <svg class="{{ request()->routeIs('student.examinations.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z" fill=""/>
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Exam Schedule</span>
            </a>
          </li>

          <!-- Student: Fee Status -->
          <li>
            <a href="{{ route('student.fees.index') }}"
               class="menu-item group {{ request()->routeIs('student.fees.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
              <svg class="{{ request()->routeIs('student.fees.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C12.4142 2 12.75 2.33579 12.75 2.75V4.03078C15.5686 4.37932 17.75 6.81126 17.75 9.75V10.25C17.75 10.6642 17.4142 11 17 11C16.5858 11 16.25 10.6642 16.25 10.25V9.75C16.25 7.40279 14.3472 5.5 12 5.5C9.65279 5.5 7.75 7.40279 7.75 9.75V14.25C7.75 16.5972 9.65279 18.5 12 18.5C14.3472 18.5 16.25 16.5972 16.25 14.25V13.75C16.25 13.3358 16.5858 13 17 13C17.4142 13 17.75 13.3358 17.75 13.75V14.25C17.75 17.1887 15.5686 19.6207 12.75 19.9692V21.25C12.75 21.6642 12.4142 22 12 22C11.5858 22 11.25 21.6642 11.25 21.25V19.9692C8.43139 19.6207 6.25 17.1887 6.25 14.25V9.75C6.25 6.81126 8.43139 4.37932 11.25 4.03078V2.75C11.25 2.33579 11.5858 2 12 2Z" fill=""/>
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Fee Status</span>
            </a>
          </li>

          <!-- Student: Notifications -->
          <li>
            <a href="{{ route('student.notifications.index') }}"
               class="menu-item group {{ request()->routeIs('student.notifications.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
              <svg class="{{ request()->routeIs('student.notifications.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C8.68629 2 6 4.68629 6 8V9.58579L4.29289 11.2929C4.10536 11.4804 4 11.7348 4 12V15C4 15.5523 4.44772 16 5 16H8.17071C8.58254 17.1652 9.69378 18 11 18H13C14.3062 18 15.4175 17.1652 15.8293 16H19C19.5523 16 20 15.5523 20 15V12C20 11.7348 19.8946 11.4804 19.7071 11.2929L18 9.58579V8C18 4.68629 15.3137 2 12 2ZM14 16H10C9.44772 16 9 15.5523 9 15V14H15V15C15 15.5523 14.5523 16 14 16ZM16 12V8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8V12L6.41421 13.5858L6 14H18L17.5858 13.5858L16 12ZM12 20C10.8954 20 10 20.8954 10 22H14C14 20.8954 13.1046 20 12 20Z" fill=""/>
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Notifications</span>
            </a>
          </li>

          @endif
          {{-- ========== END STUDENT ONLY ========== --}}
        </ul>
      </div>
    </nav>
    <!-- Sidebar Menu -->
  </div>
</aside>
