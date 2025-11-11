# CinemaTix Project Completion TODO

## 1. User Authentication System
- [x] Implement session management in functions.php or separate Session class
- [x] Complete AuthController: login, register, logout methods
- [x] Update loginUser.php and registerUser.php views with proper forms
- [x] Add password hashing (bcrypt) in UserModel
- [x] Add validation and error handling for auth forms
- [x] Protect routes that require authentication

## 2. Admin Panel CRUD Operations
- [x] Film CRUD: Create, Read, Update, Delete films with image upload
- [x] News CRUD: Create, Read, Update, Delete news with image upload
- [x] User Management: View, edit, delete users (admin only)
- [ ] Schedule Management: Add/edit showtimes for films
- [ ] Studio Management: Add/edit studios and seats
- [x] Complete AdminController methods
- [x] Update admin views (panelAdmin.php, Tambah.php, hapus.php)

## 3. Booking System
- [ ] Film detail page with schedule selection
- [ ] Seat selection interface
- [ ] Booking creation and payment simulation
- [ ] Booking history for users
- [ ] Update BookingController and BookingModel
- [ ] Handle seat availability and booking conflicts

## 4. File Upload Handling
- [ ] Implement secure image upload for posters and news
- [ ] Validate file types, sizes, and prevent malicious uploads
- [ ] Store uploaded files in public/uploads/ with proper naming

## 5. Views and Frontend
- [ ] Ensure all views are properly connected to controllers
- [ ] Add pagination for films and news lists
- [ ] Implement search and filter functionality
- [ ] Fix responsive design issues
- [ ] Add loading states and error messages

## 6. Security and Validation
- [ ] Add CSRF protection
- [ ] Sanitize all user inputs
- [ ] Implement proper error handling and logging
- [ ] Add role-based access control (user vs admin)

## 7. Testing and Finalization
- [ ] Test complete user flow: Register -> Login -> Browse -> Book
- [ ] Test admin flow: Login -> Manage content -> View bookings
- [ ] Fix any bugs and edge cases
- [ ] Optimize database queries
- [ ] Final code cleanup and documentation
