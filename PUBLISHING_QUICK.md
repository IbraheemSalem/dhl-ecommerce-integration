# 🚀 دليل سريع: رفع الحزمة على GitHub و Packagist

## الخطوات السريعة

### 1️⃣ تهيئة Git ورفع على GitHub

```bash
cd /var/www/html/v1/urbill/packages/ibraheem/dhl-ecommerce-integration

# تهيئة Git
git init
git add .
git commit -m "Initial commit: DHL eCommerce Integration v1.0.0"

# إضافة remote
git remote add origin https://github.com/IbraheemSalem/dhl-ecommerce-integration.git
git branch -M main
git push -u origin main
```

### 2️⃣ إنشاء Tag و Release

```bash
# إنشاء tag
git tag -a v1.0.0 -m "Release v1.0.0"
git push origin v1.0.0
```

ثم اذهب إلى: https://github.com/IbraheemSalem/dhl-ecommerce-integration/releases/new
- اختر Tag: `v1.0.0`
- Title: `v1.0.0 - Initial Release`
- اضغط "Publish release"

### 3️⃣ إضافة على Packagist

1. اذهب إلى: https://packagist.org/
2. سجّل الدخول بحساب GitHub
3. اذهب إلى: https://packagist.org/packages/submit
4. أدخل: `https://github.com/IbraheemSalem/dhl-ecommerce-integration`
5. اضغط "Check" ثم "Submit"
6. فعّل "Auto-Update" من صفحة الحزمة

### 4️⃣ التحقق

```bash
composer require ibraheem/dhl-ecommerce-integration
```

---

## 📝 ملاحظات

- ✅ تأكد من تحديث البريد الإلكتروني في `composer.json`
- ✅ تأكد من أن جميع الملفات موجودة
- ✅ انتظر بضع دقائق بعد النشر على Packagist

---

**للمزيد من التفاصيل:** راجع `PUBLISHING.md`

