# دليل رفع الحزمة على GitHub و Packagist

## 📋 المتطلبات الأساسية

1. حساب GitHub نشط
2. حساب Packagist نشط
3. Git مثبت على الجهاز
4. الحزمة جاهزة للنشر

---

## 🚀 الخطوات التفصيلية

### الخطوة 1: التحضير النهائي

#### 1.1 تحديث معلومات الحزمة

تأكد من تحديث:
- ✅ `composer.json` (تم التحديث)
- ✅ `README.md` (يحتوي على معلومات كاملة)
- ✅ `LICENSE` (MIT موجود)
- ✅ `.gitignore` (يستثني vendor و node_modules)

#### 1.2 تحديث البريد الإلكتروني في composer.json

```bash
# افتح composer.json وحدّث البريد الإلكتروني
# استبدل ibraheem@example.com ببريدك الحقيقي
```

---

### الخطوة 2: تهيئة Git Repository

```bash
# انتقل إلى مجلد الحزمة
cd /var/www/html/v1/urbill/packages/ibraheem/dhl-ecommerce-integration

# تهيئة Git (إذا لم يكن موجوداً)
git init

# إضافة جميع الملفات
git add .

# عمل commit أولي
git commit -m "Initial commit: DHL eCommerce Integration package"

# إضافة remote repository
git remote add origin https://github.com/IbraheemSalem/dhl-ecommerce-integration.git

# دفع الكود إلى GitHub
git branch -M main
git push -u origin main
```

---

### الخطوة 3: رفع الكود على GitHub

#### 3.1 عبر GitHub Web Interface

1. اذهب إلى: https://github.com/IbraheemSalem/dhl-ecommerce-integration
2. إذا كان المستودع فارغاً، اتبع التعليمات التي يظهرها GitHub
3. أو استخدم الأوامر أعلاه لرفع الكود

#### 3.2 عبر Command Line (الموصى به)

```bash
# تأكد من أنك في مجلد الحزمة
cd /var/www/html/v1/urbill/packages/ibraheem/dhl-ecommerce-integration

# تحقق من حالة Git
git status

# إذا كان هناك ملفات غير مضافة
git add .

# عمل commit
git commit -m "Initial release: DHL eCommerce Integration v1.0.0"

# دفع إلى GitHub
git push origin main
```

---

### الخطوة 4: إنشاء Release على GitHub

#### 4.1 إنشاء Tag

```bash
# إنشاء tag للإصدار الأول
git tag -a v1.0.0 -m "Release version 1.0.0"

# دفع الـ tag إلى GitHub
git push origin v1.0.0
```

#### 4.2 إنشاء Release عبر GitHub Web

1. اذهب إلى: https://github.com/IbraheemSalem/dhl-ecommerce-integration/releases
2. اضغط على **"Create a new release"**
3. اختر Tag: `v1.0.0`
4. Title: `v1.0.0 - Initial Release`
5. Description:
   ```markdown
   ## 🎉 Initial Release
   
   Complete DHL eCommerce Solutions REST API integration for Laravel.
   
   ### Features
   - ✅ Multi-merchant accounts support
   - ✅ Create shipments
   - ✅ Rates API
   - ✅ Tracking
   - ✅ Cancel shipment
   - ✅ PDF/PNG labels
   - ✅ Webhooks with signature verification
   - ✅ Admin panel (Blade UI)
   - ✅ Logging system
   - ✅ Events + Jobs
   - ✅ Complete test suite
   
   ### Installation
   ```bash
   composer require ibraheem/dhl-ecommerce-integration
   ```
   ```
6. اضغط **"Publish release"**

---

### الخطوة 5: ربط GitHub مع Packagist

#### 5.1 تسجيل الدخول إلى Packagist

1. اذهب إلى: https://packagist.org/
2. سجّل الدخول باستخدام حساب GitHub
3. اذهب إلى: https://packagist.org/profile/

#### 5.2 ربط GitHub Account

1. في صفحة Profile، ابحث عن **"GitHub"**
2. اضغط **"Update"** أو **"Connect"**
3. امنح Packagist صلاحيات الوصول إلى مستودعات GitHub

#### 5.3 إضافة المستودع إلى Packagist

1. اذهب إلى: https://packagist.org/packages/submit
2. أدخل رابط المستودع:
   ```
   https://github.com/IbraheemSalem/dhl-ecommerce-integration
   ```
3. اضغط **"Check"**
4. راجع المعلومات المعروضة:
   - Package Name: `ibraheem/dhl-ecommerce-integration`
   - Description: يجب أن تظهر من `composer.json`
5. اضغط **"Submit"**

#### 5.4 تفعيل Auto-Update (اختياري لكن موصى به)

1. بعد إضافة المستودع، اذهب إلى صفحة الحزمة
2. اضغط على **"Settings"** أو **"Manage"**
3. فعّل **"Auto-Update"**
4. Packagist سيتحقق تلقائياً من التحديثات عند عمل push جديد

---

### الخطوة 6: التحقق من النشر

#### 6.1 التحقق من Packagist

1. اذهب إلى: https://packagist.org/packages/ibraheem/dhl-ecommerce-integration
2. يجب أن ترى الحزمة مع جميع المعلومات
3. جرب التثبيت:
   ```bash
   composer require ibraheem/dhl-ecommerce-integration
   ```

#### 6.2 التحقق من GitHub

1. اذهب إلى: https://github.com/IbraheemSalem/dhl-ecommerce-integration
2. تأكد من وجود جميع الملفات
3. تأكد من وجود Release

---

## 🔄 تحديث الحزمة لاحقاً

### عند إضافة ميزات جديدة:

```bash
# 1. تحديث الكود
git add .
git commit -m "Add new feature: ..."

# 2. تحديث رقم الإصدار في composer.json
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

## 📝 ملاحظات مهمة

### 1. Semantic Versioning

استخدم Semantic Versioning:
- `MAJOR.MINOR.PATCH`
- مثال: `1.0.0`, `1.1.0`, `2.0.0`

### 2. composer.json Requirements

- ✅ تأكد من أن `minimum-stability` مناسب
- ✅ استخدم `prefer-stable: true`
- ✅ حدّث `require` و `require-dev` حسب الحاجة

### 3. README.md

- ✅ يجب أن يحتوي على معلومات كاملة
- ✅ أمثلة استخدام
- ✅ متطلبات التثبيت
- ✅ روابط للمستندات

### 4. Tests

- ✅ تأكد من أن جميع الاختبارات تعمل
- ✅ `phpunit.xml.dist` موجود وصحيح

### 5. .gitignore

- ✅ يستثني `vendor/`
- ✅ يستثني `composer.lock` (اختياري للحزم)
- ✅ يستثني ملفات IDE

---

## 🐛 حل المشاكل الشائعة

### المشكلة: Packagist لا يكتشف الحزمة

**الحل:**
1. تأكد من أن `composer.json` صحيح
2. تأكد من وجود tag على GitHub
3. جرب إعادة submit على Packagist

### المشكلة: Auto-Update لا يعمل

**الحل:**
1. تأكد من ربط GitHub مع Packagist
2. تأكد من تفعيل Auto-Update
3. يمكنك تحديث يدوي: https://packagist.org/packages/ibraheem/dhl-ecommerce-integration (زر "Update")

### المشكلة: Composer لا يجد الحزمة

**الحل:**
1. انتظر بضع دقائق بعد النشر
2. جرب: `composer clear-cache`
3. تأكد من أن الحزمة موجودة على Packagist

---

## ✅ Checklist قبل النشر

- [ ] `composer.json` محدث ومكتمل
- [ ] `README.md` شامل وواضح
- [ ] `LICENSE` موجود
- [ ] `.gitignore` صحيح
- [ ] جميع الملفات مضافة إلى Git
- [ ] الكود تم اختباره
- [ ] تم عمل commit و push إلى GitHub
- [ ] تم إنشاء tag للإصدار
- [ ] تم إنشاء Release على GitHub
- [ ] تم إضافة المستودع إلى Packagist
- [ ] تم تفعيل Auto-Update
- [ ] تم التحقق من التثبيت عبر Composer

---

## 🎯 روابط مفيدة

- **GitHub Repository**: https://github.com/IbraheemSalem/dhl-ecommerce-integration
- **Packagist**: https://packagist.org/packages/ibraheem/dhl-ecommerce-integration
- **Packagist Submit**: https://packagist.org/packages/submit
- **Semantic Versioning**: https://semver.org/

---

## 📞 الدعم

إذا واجهت أي مشاكل:
1. راجع هذه التعليمات
2. راجع مستندات Packagist: https://packagist.org/about
3. افتح Issue على GitHub

---

**تم إنشاء هذا الدليل بتاريخ:** 2025-01-29
**آخر تحديث:** 2025-01-29

