# Arcadia Zoo Management System

## Overview

This project is a **Zoo Management System** built with the Symfony 5 framework. The platform allows the administration of zoo services, the management of animals, and offers visitors the ability to explore zoo information, leave feedback, and contact the zoo. Different user roles (admin, employee, veterinarian, visitor) have specific permissions to manage or access certain parts of the application.

## Features

### Admin
- Full access to manage services, animals, and user roles.
- Ability to create new users (employees, veterinarians) with custom roles.
- Access to all feedback and visitor inquiries.

### Employee
- Manage daily animal feeding schedules.
- Validate and respond to visitor feedback.
- Update animal information.

### Veterinarian
- Manage health records for animals.
- Update and store information about animal check-ups, health status, and feeding details.

### Visitor
- Browse the zoo's services and animal details.
- Submit feedback and contact the zoo through a contact form.

## Project Structure

### Entities
- **User**: Handles authentication, roles, and permissions.
- **Animal**: Represents animals in the zoo.
- **Service**: Contains zoo services like tours, events, etc.
- **HealthReport**: Stores health check-up reports for each animal.
- **VisitorFeedback**: Stores feedback from visitors.

## Setup Instructions

### Prerequisites

Before you begin, make sure you have the following installed:

- PHP 7.4 or higher
- Composer
- Symfony CLI (optional but recommended)
- MySQL or any other supported database (configured in `.env`)
- Node.js and npm (for asset management)

### Installation

1. **Clone the repository:**
   git clone https://github.com/your-username/zoo-management.git
   cd zoo
   
2. **Install dependencies:**
    composer install
    npm install

3. **Set up environment variables:**
    Duplicate the .env file and customize the values for your local environment:
    cp .env .env.local

    Update the database and mailer DSN configurations:
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/zoo_db"
    MAILER_DSN=smtp://your-smtp-server.com

4. **Create the database**
    php bin/console doctrine:database:create

    **A. Add the migation files to the database**
        php bin/console doctrine:migrations:version --add --all
        php bin/console doctrine:migrations:migrate

    **B. Or Import the database.sql file that existe in database folder to your database**
        the database.sql contains the structure and the data

5. **Add data to the tables if you follow 4.A**

6. **Run the Symfony server**
    ``bash
    symfony server:start

7. **Visit the application: Open http://localhost:8000/home in your browser**

8. **API Routes**

Here is a list of all available routes in the application:

| Name                 | Path                          | Methods      | ACCESSIBLE BY      |
|----------------------|-------------------------------|--------------|--------------------|
| app_home             | `/home`                       | `GET`        | 'all'              |
| app_service_show     | `/services`                   | `GET`        | `all`              |
| app_service_create   | `/services/admin/create`      | `GET`, `POST`| `admin`            |
| app_service_edit     | `/services/edit/{id}`         | `GET`, `POST`| `admin`,`employee` |       
| app_service_delete   | `/services/admin/delete/{id}` | `GET`, `POST`| `admin`            |
| app_habitats_show    | `/habitats`                   | `GET`        | `all`              |
| app_habitats_details | `/habitats/details/{id}`      | `GET`        | `all`              |
| app_habitats_create  | `/habitats/admin/create`      | `GET`, `POST`| `admin`            |
| app_habitats_edit    | `/habitats/edit/{id}`         | `GET`, `POST`| `admin` |          |
| app_habitats_delete  | `/habitats/admin/delete/{id}` | `GET`, `POST`| `admin`            |
| app_habitats_vet_edit| `/habitats/vet/edit/{id}`     | `GET`, `POST`| `veterinary`       |


9 **Authentication Routes**

- **Login**: `/login` - POST method to authenticate users. available only for the admin,employee and veterinaire
    Admin: admin@example.com password123
    Employee emplyee@example.com password123
    Veterinaire vet@example.com password123

    The admin can create users and give them a specific role from the route app_user_create (/user/admin/create)
- **Logout**: `/logout` - POST method to log users out.


