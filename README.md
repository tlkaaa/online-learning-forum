# Online Learning Management System

> This was a school project from the course Web Information Systems

> [!NOTE]
> This project was hosted on UQ private cloud

## About

This project is an online learning management system which provides a space for student and staffs to make discussions and asking questions in a forum type format.

Some Basic Functionalities:

- A login system with password encryption and registration system with a user profile page
- Email Verification
- Posting and replying to questions anonymously
- Upvote or downvote the question or answer
- Save liked and replied post
- Pin threads
- Recommendation Algorithm based on likes, views and comments

## Languages used

- HTML, CSS (Bootstrap)
- PHP, CodeIgniter 4

## Code Explanation

### Controllers

- Calender_todo.php: view, add and remove task from the calender
- CreateAccount.php: create account and validate strong password
- Login.php: main controller for controlling login/logout status, manage and reset password
- Main.php: manage the main logic of the system, e.g. manage views, post threads and comments, likes and searches
- Profile.php: display the user's profile, verify email address, change profile picture and download a PDF transcript of account activity

### Models

- Calender_model.php: communicate with database to update and retrive to-do list
- Email_model.php: send verification email to user, and mark verified in database
- Forum_model.php: update and retrive threads data (likes, view, comments) from database
- Image_model.php: upload, retrive user profile picture from database
- User_model.php: manage user details in database

### Views

- add_todo.php: form and button for adding new todo list item
- comment.php: display each comments, author and time for each thread
- create_account.php: form for creating account
- created_account.php: show account created and link to login
- forget_password.php: form for reseting password
- home.php: display threads in home page with likes, comments and views
- liked_threads.php: display links of liked threads
- login.php: form for user login
- logout_header.php: go back to home when logged out
- logout.php: logout button
- new_comment.php: modal and buttons for adding new comment
- new_thread.php: modal and buttons for adding new thread
- profile.php: display user profile
- reset_password.php: form for reset password
- thread.php: display threads
- todo_list.php: display todo list
- update_details.php: form for updating user details

### Routes

Various `get` and `post` routes
