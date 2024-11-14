# Timesheet System

## Table of Contents

1. [Sprint 1: Initial Setup & Authentication](#sprint-1-initial-setup--authentication)
2. [Sprint 2: User Management Enhancements](#sprint-2-user-management-enhancements)
3. [Next Steps](#next-steps)
4. [Further Information](#further-information)

---

## Sprint 1: Initial Setup & Authentication

### Overview

**Sprint 1** focused on laying the foundational elements of the **Timesheet System**. The primary objectives were to set up the initial Laravel project, implement user authentication, and establish **role-based access control (RBAC)**. This sprint ensures that the application has a solid base for further feature development in subsequent sprints.

---

## Sprint 2: User Management Enhancements

### Overview

Building upon the foundational elements established in Sprint 1, **Sprint 2** delves deeper into enhancing user management functionalities within the **Timesheet System**. The primary focus areas include refining user editing capabilities, implementing dynamic Department and Team selection using **Alpine.js**, and ensuring robust **Role-Based Access Control (RBAC)** mechanisms. This sprint aims to provide administrators with a seamless experience in managing user accounts, departments, and teams, thereby laying the groundwork for more advanced features in future sprints.

### Objectives

- **Enhanced User Editing**: Improve the user editing form to accurately display and manage existing user details, including Department and Team assignments.
- **Dynamic Department & Team Selection**: Implement dynamic dropdowns for Department and Team using Alpine.js to ensure real-time updates and data integrity.
- **Role-Based Access Control (RBAC) Refinement**: Further develop RBAC to include granular permissions for Administrators, Managers, and Team Members.
- **Department & Team Management**: Create CRUD functionalities for managing Departments and Teams, allowing Administrators to organise and assign roles effectively.
- **Error Handling & Validation**: Implement comprehensive error handling and validation to maintain data consistency and provide user-friendly feedback.
- **Logging & Monitoring**: Introduce logging mechanisms to track user activities and system events for better monitoring and debugging.

### Accomplishments

#### 1. Enhanced User Editing Form

- **Dynamic Team Selection**:
    - **Issue Resolution**: Addressed the problem where the Team dropdown defaulted to `-- Select Team --` when editing a user, instead of displaying the user's current Team.
    - **Solution**: Utilised Alpine.js to pre-populate the Team dropdown with the user's existing Team based on their selected Department. This ensures that administrators see accurate and relevant information upon editing a user.

    ```blade
    <script>
        function userForm() {
            return {
                selectedDepartment: @json(old('department_id', $user->department_id)),
                selectedTeam: @json(old('team_id', $user->team_id)),
                teams: @json($teams->toArray()),

                init() {
                    if (this.selectedDepartment) {
                        const teamExists = this.teams.some(team => team.id === this.selectedTeam);
                        if (!teamExists) {
                            this.selectedTeam = null;
                        }
                    }
                },

                fetchTeams() {
                    if (this.selectedDepartment) {
                        fetch(`/admin/departments/${this.selectedDepartment}/teams`)
                            .then(response => response.json())
                            .then(data => {
                                this.teams = data.teams;
                                this.selectedTeam = null;
                            })
                            .catch(error => {
                                console.error('Error fetching teams:', error);
                            });
                    } else {
                        this.teams = [];
                        this.selectedTeam = null;
                    }
                }
            }
        }
    </script>
    ```

- **Form Validation Enhancements**:
    - Implemented client-side validation using Alpine.js to provide immediate feedback to administrators during form submissions.
    - Ensured that selected Teams belong to the chosen Departments through server-side validation in the `UserController`.

#### 2. Dynamic Department & Team Selection with Alpine.js

- **Alpine.js Integration**:
    - Leveraged Alpine.js to create reactive and dynamic forms, enhancing user experience by enabling real-time updates to the Team dropdown based on Department selection.
    - **Key Features**:
        - **Two-Way Data Binding**: Utilised `x-model` to bind form fields to Alpine.js data properties.
        - **Event Handling**: Employed `@change` events to trigger data fetching and updates.

    ```blade
    <select id="department_id" name="department_id" x-model="selectedDepartment" @change="fetchTeams()" class="...">
        <option value="">-- Select Department --</option>
        @foreach($departments as $department)
            <option value="{{ $department->id }}" {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
                {{ $department->name }}
            </option>
        @endforeach
    </select>

    <select id="team_id" name="team_id" x-model="selectedTeam" class="...">
        <option value="">-- Select Team --</option>
        <template x-for="team in teams" :key="team.id">
            <option :value="team.id" x-text="team.name"></option>
        </template>
    </select>
    ```

- **API Endpoint for Teams**:
    - Developed a dedicated route and controller method to fetch Teams based on the selected Department, ensuring efficient data retrieval and minimal load times.

    ```php
    // routes/web.php
    Route::middleware(['checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
        // ... other routes ...

        Route::get('/departments/{department}/teams', [DepartmentController::class, 'getTeams'])->name('departments.teams');

        // ... other routes ...
    });
    ```

    ```php
    // app/Http/Controllers/Admin/DepartmentController.php
    public function getTeams($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $teams = $department->teams()->select('id', 'name')->get();

        return response()->json(['teams' => $teams]);
    }
    ```

#### 3. Role-Based Access Control (RBAC) Refinement

- **Granular Permissions**:
    - Expanded RBAC to include more specific permissions, allowing for finer control over user capabilities within the application.
    - Defined roles such as **Administrator**, **Manager**, and **Team Member**, each with distinct access levels and functionalities.
  
- **Middleware Enhancements**:
    - Updated the `CheckRole` middleware to handle multiple roles and permissions more effectively, ensuring that users can only access resources pertinent to their roles.

    ```php
    // app/Http/Middleware/CheckRole.php
    public function handle($request, Closure $next, ...$roles)
    {
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
    ```

    ```php
    // routes/web.php
    Route::middleware(['checkRole:admin,manager'])->group(function () {
        // Routes accessible by Admins and Managers
    });
    ```

#### 4. Department & Team Management

- **CRUD Functionalities**:
    - Developed comprehensive Create, Read, Update, and Delete (CRUD) functionalities for managing Departments and Teams.
    - **Departments**:
        - Administrators can add, edit, view, and remove Departments, facilitating organisational structuring.
    - **Teams**:
        - Teams can be managed similarly, with the ability to assign Teams to specific Departments and designate Team Managers.

    ```php
    // app/Http/Controllers/Admin/DepartmentController.php
    public function index()
    {
        $departments = Department::all();
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        Department::create($request->all());

        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }

    // Similarly, implement show, edit, update, and destroy methods
    ```

- **User-Friendly Interfaces**:
    - Designed intuitive interfaces for Department and Team management, ensuring that Administrators can efficiently organise and oversee organisational structures.

#### 5. Error Handling & Validation

- **Client-Side Validation**:
    - Enhanced form validations using Alpine.js to provide immediate feedback, reducing the likelihood of submission errors.
  
- **Server-Side Validation**:
    - Implemented rigorous server-side checks in controllers to ensure data integrity and prevent invalid data entries.
  
    ```php
    // app/Http/Controllers/Admin/UserController.php
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:team_member,manager,admin',
            'department_id' => 'required|exists:departments,id',
            'team_id' => 'required|exists:teams,id',
            'is_active' => 'sometimes|boolean',
        ]);

        // Additional validation to ensure team belongs to department
        $department = Department::findOrFail($request->department_id);
        if (!$department->teams->contains('id', $request->team_id)) {
            return back()->withErrors(['team_id' => 'Selected team does not belong to the chosen department.'])->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'department_id' => $request->department_id,
            'team_id' => $request->team_id,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
    ```

#### 6. Logging & Monitoring

- **Activity Logging**:
    - Integrated logging mechanisms to track significant user actions, such as user creation, updates, and deletions. This facilitates accountability and aids in troubleshooting.

    ```php
    // app/Http/Controllers/Admin/UserController.php
    use Illuminate\Support\Facades\Log;

    public function store(Request $request)
    {
        // ... user creation logic ...

        Log::info("User created: User ID {$user->id} ({$user->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function update(Request $request, $id)
    {
        // ... user update logic ...

        Log::info("User updated: User ID {$user->id} ({$user->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
    ```

- **Error Monitoring**:
    - Ensured that all errors are logged appropriately, enabling swift identification and resolution of issues.

### Challenges Faced

- **Dynamic Form Handling**:
    - **Issue**: Ensuring that the Team dropdown accurately reflected the user's current Team upon editing without causing unnecessary resets.
    - **Solution**: Implemented thorough checks within the Alpine.js component to verify the existence of the selected Team within the fetched Teams, thereby preventing invalid selections.

- **Alpine.js Integration**:
    - **Issue**: Initial attempts led to syntax errors due to trailing commas and nested `x-data` directives.
    - **Solution**: Carefully revised the Blade templates to eliminate trailing commas and consolidated Alpine.js logic into a single component, ensuring clean and error-free JavaScript.

### Key Learnings

- **Importance of Data Integrity**:
    - Ensuring that Teams are correctly associated with Departments is crucial for maintaining organisational structure and preventing data inconsistencies.
  
- **Effective Client-Server Communication**:
    - Leveraging Alpine.js for dynamic form updates requires seamless communication with server-side endpoints, emphasising the need for accurate route definitions and data handling.
  
- **Robust Validation Mechanisms**:
    - Combining client-side and server-side validations enhances the reliability of the application, providing a better user experience and safeguarding against invalid data entries.

### Documentation & Best Practices

- **Consistent Coding Standards**:
    - Maintained a uniform coding style across controllers, models, and views to enhance readability and maintainability.
  
- **Comprehensive Comments**:
    - Included descriptive comments within the codebase to elucidate the purpose of functions, methods, and critical logic sections, facilitating easier onboarding for future developers.
  
- **Version Control Discipline**:
    - Regularly committed changes to GitHub with clear and descriptive commit messages, ensuring a well-documented development history.

### Screenshots & Demonstrations

*(Optional section to include visual aids illustrating the enhanced user management functionalities.)*

---

## Next Steps

With **Sprint 2** successfully completed, the **Time Tracker** application is now equipped with advanced user management capabilities, including dynamic Department and Team selections, refined RBAC, and comprehensive logging mechanisms. Moving forward, the focus will shift to further enhancing application functionalities and user experiences in subsequent sprints.

### Sprint 3: Timesheet Management & Approval Workflows

- **Timesheet Submission**:
    - Develop features allowing Team Members to submit daily or weekly timesheets.
  
- **Approval Mechanisms**:
    - Enable Managers and Administrators to review, approve, or reject submitted timesheets.
  
- **Reporting Tools**:
    - Implement reporting functionalities to generate insights on time allocations, project progress, and productivity metrics.
  
- **User Notifications**:
    - Integrate notification systems to inform users about timesheet submissions, approvals, or any required actions.
  
- **Enhanced UI/UX**:
    - Further refine the user interface to ensure intuitive navigation and a seamless user experience across all roles.

### Future Sprints

- **Sprint 4: Announcements & Notifications**
    - Allow Administrators to post announcements visible to all users.
    - Implement real-time notifications for critical updates and reminders.
  
- **Sprint 5: Performance Optimisation & Security Enhancements**
    - Optimize database queries and implement caching strategies to improve application performance.
    - Strengthen security measures to protect sensitive user data and ensure compliance with best practices.

---

