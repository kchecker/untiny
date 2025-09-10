# untinyJPG.com & untinyPNG.com

This repository contains two Laravel projects for image optimization:

- **untinyJPG.com** — for compressing JPG images  
- **untinyPNG.com** — for compressing PNG images  

Each folder is a separate Laravel project.

---

## Folder Structure

├── untinyJPG.com # JPG optimizer 
└── untinyPNG.com # PNG optimizer


---

## Setup Instructions

1. Open your terminal and go to the project folder:
   cd untinyJPG.com   # or cd untinyPNG.com


2. Install PHP dependencies:
   composer install

3. Copy the example environment file and generate the app key:
   cp .env.example .env
   php artisan key:generate

4. Start the development server:
   php artisan serve
