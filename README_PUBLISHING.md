# 📦 دليل رفع حزمة DHL eCommerce Integration

## ✅ التحضير النهائي

### 1. تحديث البريد الإلكتروني

افتح `composer.json` وحدّث البريد الإلكتروني من `ibraheem@example.com` إلى بريدك الحقيقي.

---

## 🚀 الخطوات التنفيذية

### الخطوة 1: تهيئة Git Repository

```bash
# انتقل إلى مجلد الحزمة
cd /var/www/html/v1/urbill/packages/ibraheem/dhl-ecommerce-integration

# تهيئة Git (إذا لم يكن موجوداً)
git init

# إضافة جميع الملفات
git add .

# عمل commit
git commit -m "Initial commit: DHL eCommerce Integration v1.0.0"

# إضافة remote repository
git remote add origin https://github.com/IbraheemSalem/dhl-ecommerce-integration.git

# دفع الكود
git branch -M main
git push -u origin main
```

**ملاحظة:** إذا كان المستودع موجوداً على GitHub بالفعل، استخدم:
```bash
git remote set-url origin https://github.com/IbraheemSalem/dhl-ecommerce-integration.git
```

---

### الخطوة 2: إنشاء Tag و Release

```bash
# إنشاء tag
git tag -a v1.0.0 -m "Release version 1.0.0"
git push origin v1.0.0
```

ثم اذهب إلى GitHub:
1. https://github.com/IbraheemSalem/dhl-ecommerce-integration/releases/new
2. اختر Tag: `v1.0.0`
3. Title: `v1.0.0 - Initial Release`
4. Description:
   ```markdown
   ## 🎉 Initial Release
   
   Complete DHL eCommerce Solutions REST API integration for Laravel.
   
   ### Features
   - Multi-merchant accounts support
   - Create shipments
   - Rates API
   - Tracking
   - Cancel shipment
   - PDF/PNG labels
   - Webhooks with signature verification
   - Admin panel (Blade UI)
   - Logging system
   - Events + Jobs
   - Complete test suite
   ```
5. اضغط **"Publish release"**

---

### الخطوة 3: إضافة على Packagist

#### 3.1 تسجيل الدخول
1. اذهب إلى: https://packagist.org/
2. اضغط **"Log in"** واختر **"Log in with GitHub"**
3. امنح Packagist الصلاحيات المطلوبة

#### 3.2 ربط GitHub Account
1. اذهب إلى: https://packagist.org/profile/
2. في قسم **"GitHub"**، اضغط **"Update"** أو **"Connect"**
3. امنح Packagist صلاحيات الوصول إلى مستودعات GitHub

#### 3.3 إضافة المستودع
1. اذهب إلى: https://packagist.org/packages/submit
2. أدخل رابط المستودع:
   ```
   https://github.com/IbraheemSalem/dhl-ecommerce-integration
   ```
3. اضغط **"Check"**
4. راجع المعلومات:
   - Package Name: `ibraheem/dhl-ecommerce-integration`
   - Description: يجب أن تظهر من `composer.json`
5. اضغط **"Submit"**

#### 3.4 تفعيل Auto-Update
1. بعد إضافة المستودع، اذهب إلى صفحة الحزمة
2. اضغط على **"Settings"** أو **"Manage"**
3. فعّل **"Auto-Update"**
4. Packagist سيتحقق تلقائياً من التحديثات

---

### الخطوة 4: التحقق

#### 4.1 التحقق من Packagist
- اذهب إلى: https://packagist.org/packages/ibraheem/dhl-ecommerce-integration
- يجب أن ترى الحزمة مع جميع المعلومات

#### 4.2 اختبار التثبيت
```bash
# في مشروع Laravel جديد أو تجريبي
composer require ibraheem/dhl-ecommerce-integration
```

---

## 🔄 تحديث الحزمة لاحقاً

```bash
# 1. تحديث الكود
git add .
git commit -m "Add new feature: ..."

# 2. تحديث رقم الإصدار في composer.json
# مثال: من "1.0.0" إلى "1.1.0"

# 3. تحديث CHANGELOG.md

# 4. إنشاء tag جديد
git tag -a v1.1.0 -m "Release version 1.1.0"
git push origin v1.1.0

# 5. دفع التغييرات
git push origin main

# 6. إنشاء Release جديد على GitHub (اختياري)
# 7. Packagist سيتحدث تلقائياً إذا كان Auto-Update مفعّل
```

---

## 📋 Checklist قبل النشر

- [ ] `composer.json` محدث (البريد الإلكتروني، keywords، homepage)
- [ ] `README.md` شامل وواضح
- [ ] `LICENSE` موجود (MIT)
- [ ] `.gitignore` صحيح (يستثني vendor و composer.lock)
- [ ] جميع الملفات المطلوبة موجودة
- [ ] تم عمل commit و push إلى GitHub
- [ ] تم إنشاء tag للإصدار الأول
- [ ] تم إنشاء Release على GitHub
- [ ] تم إضافة المستودع إلى Packagist
- [ ] تم تفعيل Auto-Update
- [ ] تم التحقق من التثبيت عبر Composer

---

## 🔗 روابط مهمة

- **GitHub Repository**: https://github.com/IbraheemSalem/dhl-ecommerce-integration
- **Packagist Submit**: https://packagist.org/packages/submit
- **Packagist Profile**: https://packagist.org/profile/
- **GitHub Releases**: https://github.com/IbraheemSalem/dhl-ecommerce-integration/releases

---

## 🐛 حل المشاكل

### Packagist لا يكتشف الحزمة
1. تأكد من وجود tag على GitHub
2. جرب إعادة submit على Packagist
3. انتظر بضع دقائق

### Auto-Update لا يعمل
1. تأكد من ربط GitHub مع Packagist
2. تأكد من تفعيل Auto-Update
3. يمكنك تحديث يدوي من صفحة الحزمة

### Composer لا يجد الحزمة
1. انتظر بضع دقائق بعد النشر
2. جرب: `composer clear-cache`
3. تأكد من أن الحزمة موجودة على Packagist

---

**تم إنشاء هذا الدليل:** 2025-01-29

