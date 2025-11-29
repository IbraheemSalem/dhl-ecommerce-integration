# 🚀 دليل رفع نسخة محدثة على GitHub

## 📋 الخطوات الكاملة

### الخطوة 1: التحقق من التغييرات

```bash
cd /var/www/html/v1/urbill/packages/ibraheem/dhl-ecommerce-integration

# عرض حالة Git
git status

# عرض الملفات المعدلة والجديدة
git status --short
```

### الخطوة 2: إضافة جميع الملفات

```bash
# إضافة جميع الملفات الجديدة والمعدلة
git add .

# أو إضافة ملفات محددة
git add API.md
git add USAGE.md
git add INSTALLATION.md
git add INSTALLATION_EN.md
git add README.md
git add postman_collection.json
git add API_SUMMARY.md
```

### الخطوة 3: عمل Commit

```bash
# Commit مع رسالة وصفية
git commit -m "feat: Add comprehensive API documentation and update usage guides

- Add complete API.md with full REST API documentation
- Update USAGE.md with API usage section
- Update INSTALLATION.md with API setup steps
- Add Postman collection for API testing
- Update README.md with API documentation links
- Add API_SUMMARY.md for quick reference"
```

### الخطوة 4: تحديث رقم الإصدار (اختياري)

إذا كنت تريد إنشاء إصدار جديد:

#### 4.1 تحديث composer.json

```bash
# افتح composer.json وحدّث رقم الإصدار
# مثال: من "1.0.0" إلى "1.1.0"
```

#### 4.2 تحديث CHANGELOG.md

```bash
# أضف التغييرات في CHANGELOG.md
```

### الخطوة 5: رفع التغييرات إلى GitHub

```bash
# رفع التغييرات إلى branch الحالي
git push origin main

# أو إذا كنت على branch آخر
git push origin master
```

### الخطوة 6: إنشاء Tag جديد (لإصدار جديد)

```bash
# إنشاء tag للإصدار الجديد
git tag -a v1.1.0 -m "Release v1.1.0 - API Documentation Update"

# رفع الـ tag
git push origin v1.1.0
```

### الخطوة 7: إنشاء Release على GitHub (اختياري)

1. اذهب إلى: https://github.com/IbraheemSalem/dhl-ecommerce-integration/releases/new
2. اختر Tag: `v1.1.0`
3. Title: `v1.1.0 - API Documentation Update`
4. Description:
   ```markdown
   ## 🎉 New Features
   
   ### API Documentation
   - ✅ Complete REST API documentation (API.md)
   - ✅ Full API Controller implementation
   - ✅ Request/Response examples
   - ✅ Postman collection
   - ✅ cURL, JavaScript, PHP examples
   
   ### Updated Documentation
   - ✅ Updated USAGE.md with API section
   - ✅ Updated INSTALLATION.md with API setup
   - ✅ Updated README.md with API links
   
   ### Files Added
   - `API.md` - Complete API documentation
   - `postman_collection.json` - Postman collection
   - `API_SUMMARY.md` - Quick API reference
   
   ## 📚 Documentation
   
   - **API Guide**: See [API.md](API.md)
   - **Usage Guide**: See [USAGE.md](USAGE.md)
   - **Installation**: See [INSTALLATION.md](INSTALLATION.md)
   ```
5. اضغط **"Publish release"**

---

## 🔄 تحديث Packagist (تلقائي)

إذا كان Auto-Update مفعّل على Packagist، سيتم التحديث تلقائياً خلال بضع دقائق.

إذا لم يكن مفعّل:
1. اذهب إلى: https://packagist.org/packages/ibraheem/dhl-ecommerce-integration
2. اضغط على زر **"Update"**

---

## ✅ Checklist قبل الرفع

- [ ] تم مراجعة جميع التغييرات (`git status`)
- [ ] تم إضافة جميع الملفات (`git add .`)
- [ ] تم عمل commit بوصف واضح
- [ ] تم تحديث رقم الإصدار في composer.json (إذا لزم)
- [ ] تم تحديث CHANGELOG.md (إذا لزم)
- [ ] تم رفع التغييرات (`git push`)
- [ ] تم إنشاء tag جديد (إذا لزم)
- [ ] تم إنشاء Release على GitHub (إذا لزم)
- [ ] تم التحقق من تحديث Packagist

---

## 📝 مثال كامل (Copy & Paste)

```bash
# 1. الانتقال إلى مجلد الحزمة
cd /var/www/html/v1/urbill/packages/ibraheem/dhl-ecommerce-integration

# 2. التحقق من التغييرات
git status

# 3. إضافة جميع الملفات
git add .

# 4. عمل Commit
git commit -m "feat: Add comprehensive API documentation and update usage guides

- Add complete API.md with full REST API documentation
- Update USAGE.md with API usage section
- Update INSTALLATION.md with API setup steps
- Add Postman collection for API testing
- Update README.md with API documentation links
- Add API_SUMMARY.md for quick reference"

# 5. رفع التغييرات
git push origin main

# 6. إنشاء tag (إذا كان إصدار جديد)
git tag -a v1.1.0 -m "Release v1.1.0 - API Documentation Update"
git push origin v1.1.0
```

---

## 🐛 حل المشاكل

### المشكلة: "Your branch is ahead of 'origin/main'"

**الحل:**
```bash
git push origin main
```

### المشكلة: "Updates were rejected"

**الحل:**
```bash
# سحب التغييرات من GitHub أولاً
git pull origin main

# ثم رفع التغييرات
git push origin main
```

### المشكلة: "fatal: not a git repository"

**الحل:**
```bash
# تهيئة Git (إذا لم يكن موجوداً)
git init
git remote add origin https://github.com/IbraheemSalem/dhl-ecommerce-integration.git
```

### المشكلة: "Permission denied"

**الحل:**
- تأكد من إعداد SSH keys أو استخدام HTTPS مع credentials
- تحقق من صلاحيات الوصول إلى المستودع

---

## 📊 الملفات التي سيتم رفعها

### ملفات جديدة:
- ✅ `API.md` - دليل API الكامل
- ✅ `postman_collection.json` - Postman Collection
- ✅ `API_SUMMARY.md` - ملخص API
- ✅ `UPDATE_GITHUB.md` - هذا الملف

### ملفات محدثة:
- ✅ `USAGE.md` - محدث بقسم API
- ✅ `INSTALLATION.md` - محدث بخطوات API
- ✅ `INSTALLATION_EN.md` - محدث
- ✅ `README.md` - محدث بروابط API

---

## 🔗 روابط مفيدة

- **GitHub Repository**: https://github.com/IbraheemSalem/dhl-ecommerce-integration
- **Packagist**: https://packagist.org/packages/ibraheem/dhl-ecommerce-integration
- **Releases**: https://github.com/IbraheemSalem/dhl-ecommerce-integration/releases

---

**تم إنشاء هذا الدليل:** 2025-01-29

