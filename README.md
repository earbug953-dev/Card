# 🎫 VIP Membership Card — Laravel Application

A complete Laravel membership card management system with:
- **Public fan shop** — fans browse plans and buy cards
- **Live chat** — fans chat with management to complete payment
- **Admin approval** — admin reviews, approves/rejects, issues access codes
- **VIP Card display** — personalised card with fan photo + celebrity photo
- **Admin panel** — manage plans, celebrities, transactions, chats

---

## 🚀 Quick Setup

```bash
# 1. Install dependencies
composer install

# 2. Copy env
cp .env.example .env

# 3. Generate key
php artisan key:generate

# 4. Configure database in .env (SQLite is easiest):
#    DB_CONNECTION=sqlite
#    (and touch database/database.sqlite)

# 5. Run migrations
php artisan migrate

# 6. Seed demo data
php artisan db:seed

# 7. Link storage
php artisan storage:link

# 8. Run server
php artisan serve
```

Then open: **http://localhost:8000**

---

## 🔑 Login Credentials

| Role  | Email           | Password |
|-------|-----------------|----------|
| Admin | admin@demo.com  | password |
| Fan   | fan@demo.com    | password |

---

## 📋 User Flow

1. **Fan** registers at `/register` → browses plans at `/shop`
2. **Fan** selects a plan → fills checkout form (uploads their photo, address)
3. **Fan** is taken to **live chat** with management
4. **Admin** logs in → sees open chats → approves payment → issues unique card code
5. A notification appears in chat with the **VIP Card ID code**
6. **Fan** visits `/card/{code}` → sees their personalised VIP card
   - Fan photo on the left
   - Celebrity photo on the right (set by admin per plan)
   - Matching the reference image design

---

## 🃏 Card Design

The VIP card matches the reference image:
- Black background with gold border shimmer
- VIP crown emblem (top left)
- Activation fee (top right)  
- "MEMBERSHIP CARD" title in gold
- Member address and details
- **Fan's photo** (bottom left circle)
- **Celebrity photo** (bottom right circle)
- Gold footer bar

---

## 👑 Admin Features

- **Plans & Celebrities** — create plans, upload celebrity name + photo per plan
- **Fan Chats** — real-time chat list, approve/reject payments, quick replies
- **Transactions** — full history of all purchases
- **Stats** — revenue, breakdowns, top plans
- **Issue Card Code** — unique VIP code generated on approval

---

## 📁 Key Files

```
resources/views/
├── layouts/
│   ├── app.blade.php      (admin sidebar layout)
│   ├── public.blade.php   (fan-facing nav/footer)
│   └── auth.blade.php     (login/register)
├── shop/index.blade.php   (public homepage)
├── checkout/form.blade.php(buy card form)
├── chat/show.blade.php    (live chat)
├── card/display.blade.php (VIP card view)
├── admin/
│   ├── dashboard.blade.php
│   ├── all-chats.blade.php
│   ├── transactions.blade.php
│   └── stats.blade.php
├── plans/index.blade.php  (admin: plans + celebrity upload)
└── dashboard/user.blade.php (fan dashboard)

public/css/master.css      (full luxury dark-gold theme)
public/js/app.js           (animations, modals, nav)
```
