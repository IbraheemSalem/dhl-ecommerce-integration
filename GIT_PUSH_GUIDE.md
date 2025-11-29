# 📤 دليل رفع التحديثات على GitHub - خطوة بخطوة

## 🎯 الهدف

رفع جميع الملفات الجديدة والمحدثة إلى GitHub.

---

## 📋 الملفات الجديدة/المحدثة

### ملفات جديدة:
- ✅ `API.md` - دليل API الكامل
- ✅ `postman_collection.json` - Postman Collection
- ✅ `API_SUMMARY.md` - ملخص API
- ✅ `UPDATE_GITHUB.md` - دليل التحديث
- ✅ `QUICK_UPDATE.md` - تحديث سريع
- ✅ `GIT_PUSH_GUIDE.md` - هذا الملف

### ملفات محدثة:
- ✅ `USAGE.md` - محدث بقسم API
- ✅ `INSTALLATION.md` - محدث بخطوات API
- ✅ `INSTALLATION_EN.md` - محدث
- ✅ `README.md` - محدث بروابط API

---

## 🚀 السيناريو 1: Git مهيأ بالفعل

### الخطوة 1: الانتقال إلى المجلد

```bash
cd /var/www/html/v1/urbill/packages/ibraheem/dhl-ecommerce-integration
```

### الخطوة 2: التحقق من الحالة

```bash
git status
```

### الخطوة 3: إضافة جميع الملفات

```bash
# إضافة جميع الملفات
git add .

# أو إضافة ملفات محددة
git add API.md USAGE.md INSTALLATION.md INSTALLATION_EN.md README.md
git add postman_collection.json API_SUMMARY.md
```

### الخطوة 4: عمل Commit

```bash
git commit -m "feat: Add comprehensive API documentation and update usage guides

- Add complete API.md with full REST API documentation
- Add API Controller implementation with all endpoints
- Update USAGE.md with API usage section
- Update INSTALLATION.md with API setup steps
- Add Postman collection for API testing
- Update README.md with API documentation links
- Add API_SUMMARY.md for quick reference"
```

### الخطوة 5: رفع التغييرات

```bash
# رفع إلى main branch
git push origin main

# أو إذا كان branch اسمه master
git push origin master
```

### الخطوة 6: إنشاء Tag (اختياري - لإصدار جديد)

```bash
# تحديث رقم الإصدار في composer.json أولاً (مثلاً: 1.0.0 → 1.1.0)

# إنشاء tag
git tag -a v1.1.0 -m "Release v1.1.0 - API Documentation Update"

# رفع الـ tag
git push origin v1.1.0
```

---

## 🆕 السيناريو 2: Git غير مهيأ

### الخطوة 1: تهيئة Git

```bash
cd /var/www/html/v1/urbill/packages/ibraheem/dhl-ecommerce-integration

# تهيئة Git
git init

# إضافة remote repository
git remote add origin https://github.com/IbraheemSalem/dhl-ecommerce-integration.git

# تعيين branch الرئيسي
git branch -M main
```

### الخطوة 2: إضافة جميع الملفات

```bash
git add .
```

### الخطوة 3: عمل Commit أولي

```bash
git commit -m "Initial commit: DHL eCommerce Integration with API documentation

- Complete package implementation
- Full API documentation (API.md)
- Updated usage guides
- Postman collection
- All features and services"
```

### الخطوة 4: رفع الكود

```bash
git push -u origin main
```

---

## 🔄 السيناريو 3: تحديث إصدار موجود

### الخطوة 1: التحقق من الإصدار الحالي

```bash
# عرض آخر tag
git tag -l

# عرض آخر commit
git log --oneline -5
```

### الخطوة 2: تحديث رقم الإصدار

```bash
# افتح composer.json وحدّث رقم الإصدار
# مثال: من "1.0.0" إلى "1.1.0"
```

### الخطوة 3: تحديث CHANGELOG.md

```bash
# أضف التغييرات في CHANGELOG.md
```

### الخطوة 4: إضافة التغييرات

```bash
git add .
git commit -m "chore: Bump version to 1.1.0

- Add API documentation
- Update usage guides
- Add Postman collection"
```

### الخطوة 5: رفع وإنشاء Tag

```bash
git push origin main

# إنشاء tag للإصدار الجديد
git tag -a v1.1.0 -m "Release v1.1.0 - API Documentation Update"
git push origin v1.1.0
```

---

## 📝 مثال كامل (Copy & Paste)

```bash
#!/bin/bash

# الانتقال إلى مجلد الحزمة
cd /var/www/html/v1/urbill/packages/ibraheem/dhl-ecommerce-integration

# التحقق من حالة Git
echo "=== Git Status ==="
git status

# إضافة جميع الملفات
echo ""
echo "=== Adding files ==="
git add .

# عرض الملفات المضافة
echo ""
echo "=== Files to be committed ==="
git status --short

# عمل Commit
echo ""
echo "=== Committing changes ==="
git commit -m "feat: Add comprehensive API documentation and update usage guides

- Add complete API.md with full REST API documentation
- Add API Controller implementation with all endpoints
- Update USAGE.md with API usage section
- Update INSTALLATION.md with API setup steps
- Add Postman collection for API testing
- Update README.md with API documentation links
- Add API_SUMMARY.md for quick reference"

# رفع التغييرات
echo ""
echo "=== Pushing to GitHub ==="
git push origin main

echo ""
echo "✅ Done! Changes pushed to GitHub"
```

---

## ✅ Checklist النهائي

### قبل الرفع:
- [ ] تم مراجعة جميع التغييرات
- [ ] تم التحقق من أن جميع الملفات موجودة
- [ ] تم تحديث رقم الإصدار (إذا لزم)
- [ ] تم تحديث CHANGELOG.md (إذا لزم)

### أثناء الرفع:
- [ ] تم إضافة جميع الملفات (`git add .`)
- [ ] تم عمل commit بوصف واضح
- [ ] تم رفع التغييرات (`git push`)

### بعد الرفع:
- [ ] تم التحقق من GitHub أن التغييرات موجودة
- [ ] تم إنشاء tag جديد (إذا لزم)
- [ ] تم إنشاء Release على GitHub (إذا لزم)
- [ ] تم التحقق من تحديث Packagist

---

## 🐛 حل المشاكل الشائعة

### 1. "fatal: not a git repository"

**الحل:**
```bash
git init
git remote add origin https://github.com/IbraheemSalem/dhl-ecommerce-integration.git
```

### 2. "Updates were rejected because the remote contains work"

**الحل:**
```bash
# سحب التغييرات أولاً
git pull origin main --rebase

# ثم رفع التغييرات
git push origin main
```

### 3. "Permission denied (publickey)"

**الحل:**
- استخدم HTTPS بدلاً من SSH
- أو أضف SSH key إلى GitHub

### 4. "branch 'main' does not exist"

**الحل:**
```bash
# إنشاء branch جديد
git checkout -b main
git push -u origin main
```

---

## 📊 ملخص الملفات

### ملفات التوثيق:
- `API.md` - دليل API الكامل (جديد)
- `USAGE.md` - دليل الاستخدام (محدث)
- `INSTALLATION.md` - دليل التثبيت (محدث)
- `INSTALLATION_EN.md` - Installation Guide (محدث)
- `README.md` - الوثائق الرئيسية (محدث)
- `API_SUMMARY.md` - ملخص API (جديد)

### ملفات Postman:
- `postman_collection.json` - Postman Collection (جديد)

### ملفات إضافية:
- `UPDATE_GITHUB.md` - دليل التحديث (جديد)
- `QUICK_UPDATE.md` - تحديث سريع (جديد)
- `GIT_PUSH_GUIDE.md` - هذا الملف (جديد)

---

## 🔗 روابط مفيدة

- **GitHub Repository**: https://github.com/IbraheemSalem/dhl-ecommerce-integration
- **Packagist**: https://packagist.org/packages/ibraheem/dhl-ecommerce-integration
- **Releases**: https://github.com/IbraheemSalem/dhl-ecommerce-integration/releases
- **Issues**: https://github.com/IbraheemSalem/dhl-ecommerce-integration/issues

---

## 📞 الدعم

إذا واجهت أي مشاكل:
1. راجع هذا الدليل
2. راجع `UPDATE_GITHUB.md` للمزيد من التفاصيل
3. راجع `QUICK_UPDATE.md` للخطوات السريعة

---

**تم إنشاء هذا الدليل:** 2025-01-29  
**آخر تحديث:** 2025-01-29

