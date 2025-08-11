# Changelog

All notable changes to BD Product Carousel Pro will be documented in this file.

## [2.7.2] - 2025-08-11

### 🎯 Compact Layout Improvements
- **IMPROVED:** Significantly reduced whitespace throughout admin interface
- **IMPROVED:** More compact section padding (50px → 25px)
- **IMPROVED:** Reduced form group spacing and padding for efficiency
- **IMPROVED:** Smaller input field padding (14px → 10px) for tighter layout
- **IMPROVED:** Reduced margins between form elements and sections
- **IMPROVED:** More compact radio/checkbox groups with reduced padding
- **IMPROVED:** Smaller font sizes and spacing for labels and help text
- **IMPROVED:** Tighter shortcode output section with reduced margins
- **IMPROVED:** Overall more space-efficient design while maintaining usability

## [2.7.1] - 2025-08-11

### 🎨 Admin Interface Improvements
- **IMPROVED:** Enhanced spacing and layout in admin interface
- **IMPROVED:** Better visual hierarchy with increased section padding (35px → 50px)
- **IMPROVED:** Improved form organization with structured section wrappers
- **IMPROVED:** Enhanced input and select field styling with better padding and focus states
- **IMPROVED:** Better visual separation between form sections and groups
- **IMPROVED:** Improved radio and checkbox group styling with enhanced spacing
- **IMPROVED:** Enhanced shortcode output section with visual indicators
- **IMPROVED:** Better alignment in input rows and form elements
- **IMPROVED:** Added emoji icons to section headers for better visual identification
- **IMPROVED:** Cleaner overall layout with improved margins and gaps

## [2.6.0] - 2025-08-08

### 🚀 Modern GitHub Update System
- **NEW:** Implemented BD GitHub Update System according to guide v1.1
- **NEW:** Modern `BD_Plugin_Updater` class replacing old GitHub updater
- **NEW:** GitHub Actions workflow for automatic release generation
- **NEW:** WordPress-native update notifications and one-click updates
- **NEW:** Automatic changelog generation from commit history
- **NEW:** Proper Update URI in plugin header for WordPress compatibility
- **NEW:** Secure ZIP file creation and distribution via GitHub releases

### 🔧 Technical Improvements
- **UPDATED:** Plugin header with proper WordPress update fields
- **UPDATED:** Plugin constants for better organization
- **REMOVED:** Old `github-updater.php` file (replaced with modern implementation)
- **REMOVED:** Outdated `GITHUB_SETUP.md` file
- **UPDATED:** README.md with modern update system documentation

### 📋 Workflow Automation
- **NEW:** Automatic version detection from plugin header
- **NEW:** Release creation only when version changes
- **NEW:** Proper file exclusions for clean plugin ZIP
- **NEW:** Norwegian language support in release descriptions
- **NEW:** Manual workflow dispatch option for testing

## [2.0.0] - 2025-07-23

### 🎨 Major Design Overhaul
- **NEW:** Implemented complete BD Design Guide v3.0
- **NEW:** Modern gradient-based color scheme with BD branding
- **NEW:** Card-based layout with advanced hover effects
- **NEW:** Smooth animations and transitions throughout
- **NEW:** Responsive design optimized for all devices

### 🔧 BD Menu Integration
- **NEW:** Integrated bd-menu-helper.php for unified admin experience
- **NEW:** Plugin now appears under "Buene Data" main menu
- **NEW:** 🎠 carousel emoji icon for easy identification
- **NEW:** Consistent branding with other BD plugins

### 📱 Admin Interface Improvements
- **NEW:** Complete admin interface redesign following BD standards
- **NEW:** Tab-based navigation (Generator, Preview, Documentation)
- **NEW:** Live shortcode generation with real-time updates
- **NEW:** Improved form controls with better UX
- **NEW:** Built-in documentation and examples
- **NEW:** Modern gradient text effects and styling
- **NEW:** Responsive admin interface for mobile devices

### ⚡ Enhanced Carousel Features
- **NEW:** Dynamic speed control per carousel instance
- **NEW:** Improved Swiper.js integration with v11
- **NEW:** Enhanced touch and swipe support
- **NEW:** Pagination with dynamic bullets
- **NEW:** Better accessibility (ARIA labels, keyboard navigation)
- **NEW:** Improved loading states and error handling
- **NEW:** Enhanced breakpoints for better responsive behavior

### 🛠 Code Quality & Performance
- **NEW:** Input validation and sanitization for all shortcode attributes
- **NEW:** WooCommerce dependency checking with user-friendly errors
- **NEW:** Cross-theme compatibility improvements
- **NEW:** Proper plugin activation/deactivation hooks
- **NEW:** Enhanced error handling and debugging support
- **NEW:** Optimized CSS with better specificity and performance
- .gitignore file for better version control
- Changelog for tracking version history

### Enhanced
- Plugin header with GitHub repository information
- Better error handling in update process
- Improved version comparison logic

### Technical
- New `BD_Product_Carousel_GitHub_Updater` class
- GitHub API integration for release checking
- Automatic download and installation of updates

## [1.x.x] - Previous versions
- Basic product carousel functionality
- Admin panel for shortcode generation
- WooCommerce integration
- Multiple display modes (latest, category, sale, featured, best-sellers)
- Responsive design
- Shadow effects option
