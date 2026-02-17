# 🎯Ai Recruiter - AI-Powered Recruitment Platform

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

## 📖 About Ai Recruiter 
**Ai Recruiter** is an innovative AI-powered recruitment platform that revolutionizes the hiring process by automating technical interviews. The system leverages advanced AI to generate role-specific interview questions, conduct live interviews with real-time speech-to-text transcription, and provide comprehensive candidate assessments.

### ✨ Key Highlights

- 🤖 **AI Interview Generation** - Automatically generate role-specific technical interview questions
- 🎙️ **Live AI Interviews** - Real-time voice interviews with speech-to-text transcription using AssemblyAI
- 📄 **Resume Analysis** - AI-powered resume screening and candidate evaluation
- 📊 **Detailed Reporting** - Comprehensive interview reports and candidate assessments
- 💳 **Integrated Billing** - Stripe payment integration for premium features
- 📧 **Email Notifications** - Automated email system for interview invitations.

## 🚀 Features

### For Recruiters

- **Interview Creation**
  - Create customized interviews with AI-generated questions
  - Define job roles, requirements, and experience levels
  - Generate shareable interview links for candidates
  - Track all interviews from a centralized dashboard

- **Interview Management**
  - View all active and completed interviews
  - Access detailed interview reports and transcripts
  - Review candidate responses and AI assessments
  - Export interview data and analytics

- **Resume Screening**
  - Upload and analyze candidate resumes
  - AI-powered skill extraction and matching
  - Automated candidate ranking and recommendations

- **Billing & Payments**
  - Stripe integration for subscription management
  - Secure payment processing
  - Usage tracking and invoicing

### For Candidates

- **Live Interview Experience**
  - Join interviews via unique shareable links
  - Real-time speech-to-text transcription
  - Interactive AI-driven interview process
  - User-friendly interview interface

## 🛠️ Technology Stack

### Backend
- **Framework:** Laravel 10.x
- **Language:** PHP 8.1+
- **Authentication:** Laravel Breeze (with Laravel Sanctum)
- **Database:** MySQL
- **Payment:** Stripe PHP SDK
- **HTTP Client:** Guzzle

### Frontend
- **CSS Framework:** TailwindCSS 3.x with @tailwindcss/forms
- **JavaScript:** Alpine.js 3.x
- **Build Tool:** Vite 7.x
- **HTTP Client:** Axios
- **Animations:** AOS (Animate On Scroll)

### AI & APIs
- **AI Questions:** GROQ API for intelligent question generation
- **Speech-to-Text:** AssemblyAI for real-time transcription
- **Audio Recording:** RecordRTC, node-record-lpcm16

### Development Tools
- **Testing:** PHPUnit
- **Code Quality:** Laravel Pint
- **Container:** Laravel Sail (Docker)
- **Mocking:** Mockery
- **Error Handling:** Spatie Laravel Ignition

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- PHP >= 8.1
- Composer
- Node.js >= 16.x and npm
- MySQL >= 5.7 or MariaDB >= 10.3
- Git

## 🔧 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/Adnan-Asad1/AI-Recruiter.git
cd AI-Recruiter
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

Create a `.env` file by copying the example:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 5. Configure Environment Variables

Open `.env` and configure the following

#### Database Configuration
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Smart_Hire
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

#### Email Configuration (Gmail)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="your_email@gmail.com"
MAIL_FROM_NAME="Smart Hire"
```

#### API Keys
```env
# GROQ API for AI question generation
GROQ_API_KEY=your_groq_api_key

# AssemblyAI for speech-to-text
ASSEMBLYAI_API_KEY=your_assemblyai_api_key

# Stripe for payments
STRIPE_PUBLIC_KEY=your_stripe_public_key
STRIPE_SECRET_KEY=your_stripe_secret_key
```

#### Queue Configuration
```env
QUEUE_CONNECTION=database
```

### 6. Database Setup

Create the database:

```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE Smart_Hire;
exit;
```

Run migrations:

```bash
php artisan migrate
```

### 7. Build Frontend Assets

```bash
npm run build
```

For development with hot reload:

```bash
npm run dev
```

### 8. Start the Application

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## 📚 Usage Guide

### Setting Up Your First Interview

1. **Register/Login**
   - Navigate to `/register` to create an account
   - Or login at `/login` if you have an account

2. **Create Interview**
   - Go to Dashboard
   - Click "Create Interview"
   - Fill in job details (title, description, experience level)
   - Click "Generate Questions" - AI will create role-specific questions
   - Review and edit questions if needed
   - Save the interview

3. **Share Interview Link**
   - After creating, you'll receive a unique interview link
   - Share this link with candidates via email or copy to clipboard

4. **Candidate Takes Interview**
   - Candidate clicks the link and joins the interview
   - Live audio interview with real-time transcription
   - AI asks questions and records responses

5. **Review Results**
   - View all interviews from "All Interviews" page
   - Click on specific interview for detailed report
   - Review transcripts, scores, and AI assessment

### Resume Screening

1. Navigate to "Feed Resume" section
2. Upload candidate resume (PDF/DOC)
3. View AI-powered analysis and recommendations

### Billing

1. Go to "Billing" section
2. Choose your plan
3. Enter payment details (powered by Stripe)
4. Complete payment securely

## 📁 Project Structure

```
Smart-Hire Laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── interview_controller.php      # Interview operations
│   │   │   ├── InterviewDetails_controller.php  # Interview details & reports
│   │   │   ├── Resume_Controller.php         # Resume analysis
│   │   │   ├── StripeController.php          # Payment processing
│   │   │   ├── MailController.php            # Email operations
│   │   │   └── SettingsController.php        # User settings
│   │   └── Middleware/                       # Custom middleware
│   ├── Models/
│   │   ├── User.php                          # User model
│   │   ├── Interviewer.php                   # Interview sessions
│   │   ├── Conversation.php                  # Interview conversations
│   │   └── Report.php                        # Interview reports
│   └── Mail/                                 # Email templates
├── database/
│   ├── migrations/                           # Database migrations
│   └── seeders/                              # Database seeders
├── resources/
│   └── views/
│       ├── interview/                        # Interview views
│       ├── interview_Details/                # Interview details views
│       ├── resume/                           # Resume screening views
│       ├── billing/                          # Billing views
│       ├── settings/                         # Settings views
│       └── auth/                             # Authentication views
├── routes/
│   ├── web.php                               # Web routes
│   └── api.php                               # API routes
└── public/                                    # Public assets
```

## 🔑 Key Routes

### Authentication
- `GET /register` - User registration
- `GET /login` - User login
- `POST /logout` - User logout

### Interviews
- `GET /dashboard` - Main dashboard
- `GET /interview/create` - Create new interview
- `POST /generate/questions` - Generate AI questions
- `POST /interview/store` - Save interview
- `GET /All-Interviews` - View all interviews
- `GET /interview/specific/card/{id}` - View interview details
- `GET /join-call/{id}` - Candidate interview link

### Resume
- `GET /feed-resume` - Upload resume
- `POST /resume-result` - Get resume analysis
- `GET /resume/report` - View resume report

### Billing
- `GET /billing` - Billing page
- `POST /charge` - Process payment

### Settings
- `GET /settings` - User settings
- `PATCH /settings/account` - Update account
- `PATCH /settings/password` - Change password

## 🔒 API Keys Setup

### GROQ API (AI Question Generation)
1. Visit [GROQ Cloud](https://console.groq.com/)
2. Create an account and generate API key
3. Add to `.env`: `GROQ_API_KEY=your_key`

### AssemblyAI (Speech-to-Text)
1. Visit [AssemblyAI](https://www.assemblyai.com/)
2. Sign up and get your API key
3. Add to `.env`: `ASSEMBLYAI_API_KEY=your_key`

### Stripe (Payments)
1. Visit [Stripe Dashboard](https://dashboard.stripe.com/)
2. Get your API keys (test mode for development)
3. Add to `.env`:
   - `STRIPE_PUBLIC_KEY=pk_test_...`
   - `STRIPE_SECRET_KEY=sk_test_...`

## 🧪 Testing

Run PHPUnit tests:

```bash
php artisan test
```

Run specific test suite:

```bash
php artisan test --testsuite=Feature
```

## 🚢 Deployment

### Production Build

```bash
# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Configure environment
cp .env.example .env
php artisan key:generate

# Optimize application
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force
```

### Queue Worker (Required for Background Jobs)

```bash
php artisan queue:work --daemon
```

Or use supervisor/systemd for production.

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors

- **Adnan Asad** - [GitHub](https://github.com/Adnan-Asad1)

## 🙏 Acknowledgments

- Laravel Framework
- AssemblyAI for speech recognition
- GROQ for AI capabilities
- Stripe for payment processing
- All contributors and supporter

## 📧 Support

For support, email daniiasad786@gmail.com or open an issue in the GitHub repository.

---

<p align="center">Made with ❤️ by Adnan Asad</p>
