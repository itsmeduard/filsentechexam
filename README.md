# Filsen Eduard Valdez Technical Exam - JDJ Consulting / MID Construction

This is a technical exam for JDJ-Consulting and Mid Construction, created by [Filsen Eduard Valdez](https://filseneduardvaldez.bss.design).

Alongside the roles and permissions manager, there are a few example CRUD operations, including User Management and Task Management.

The tech stack used for this project is Laravel + Livewire + Tailwind
- - - - -

## Screenshots 

![Filsen Tech Exam Img 1](https://i.imgur.com/G3HIBhS.png)

- - - - -

![Filsen Tech Exam Img 2](https://i.imgur.com/il3xnWX.png)

- - - - -

![Filsen Tech Exam Img 3](https://i.imgur.com/RCjOVNr.png)

- - - - -


## How to use

- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database credentials there
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)
- That's it: launch the main URL. 
- You can login to adminpanel by going go `/login` URL and login with credentials __admin@admin.com__ - __password__


## Technical Exam

**Instructions:**
1. Implement a RESTful API for User and Task management.
2. Ensure proper authentication and authorization for the API endpoints.
3. Use Node.js and the built-in `http` module or a lightweight framework like Express.js.
4. Do not use any ORM (Object-Relational Mapping) library.
5. Provide clear instructions on how to set up and run the application.

**Requirements:**

1. **User Management:**
    - Implement CRUD (Create, Read, Update, Delete) operations for Users.
    - Each user should have the following fields: `id`, `name`, `email`, `password`.
    - Implement user registration and login functionality.
    - Ensure password hashing and secure storage.

2. **Task Management:**
    - Implement CRUD operations for Tasks.
    - Each task should have the following fields: `id`, `title`, `description`, `status` (e.g., 'To Do', 'In Progress', 'Done'), `userId` (foreign key referencing the user who created the task).
    - Ensure that users can only access and modify their own tasks.

3. **Authentication and Authorization:**
    - Implement a token-based authentication system (e.g., JWT) for the API endpoints.
    - Ensure that only authenticated users can perform CRUD operations on their own tasks.
    - Implement role-based access control (RBAC) to differentiate between regular users and administrators (if applicable).

4. **Error Handling and Response:**
    - Provide meaningful error messages and appropriate HTTP status codes for all API responses.
    - Handle common error scenarios, such as invalid input, resource not found, and unauthorized access.

5. **Code Organization and Documentation:**
    - Organize your code in a modular and maintainable structure.
    - Include a README file with instructions on how to set up and run the application.
    - Document your API endpoints, including request/response formats and any authentication requirements.

**Bonus Tasks (Optional):**
1. Implement pagination and sorting for the task list.
2. Add the ability to search and filter tasks based on various criteria (e.g., title, status, user).
3. Implement a simple in-memory database or use a lightweight database like SQLite for data storage.

