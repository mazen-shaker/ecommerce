# E-commerce Project — PHP MVC

مشروع متجر إلكتروني مكتوب بـ PHP بدون Framework، بيطبّق مبدأ **MVC** و **OOP**، وبيستخدم Router شبيه بـ Laravel لكن أبسط وبقيود مختلفة (موضحة في الأسفل).

> **لو أول مرة تفتح المشروع:** اقرأ قسم [التشغيل](#1-التشغيل) وبعده قسم [الـ basePath](#2-الـ-basepath-مهم-جداً)، الاتنين دول هما أكتر سبب لمشاكل "الصفحة مش بتفتح / الرابط بيروح مكان غلط".

---

## المحتويات

1. [التشغيل](#1-التشغيل)
2. [الـ basePath (مهم جداً)](#2-الـ-basepath-مهم-جداً)
3. [دورة الطلب (Request Lifecycle)](#3-دورة-الطلب-request-lifecycle)
4. [إضافة Feature جديدة خطوة بخطوة](#4-إضافة-feature-جديدة-خطوة-بخطوة)
5. [شرح أجزاء المشروع](#5-شرح-أجزاء-المشروع)
6. [حل المشاكل الشائعة](#6-حل-المشاكل-الشائعة)
7. [قواعد الفريق](#7-قواعد-الفريق)
8. [قيود ومشاكل معروفة](#8-قيود-ومشاكل-معروفة)

---

## 1. التشغيل

### المتطلبات

| المطلوب | ملاحظات |
|---|---|
| PHP **8.0 أو أحدث** | الكود بيستخدم `str_starts_with` و union types (`array\|false`) |
| إضافات PHP | `pdo_mysql`, `mbstring` |
| MySQL / MariaDB | |
| Composer | لتوليد ملفات الـ autoload |
| Apache مع `mod_rewrite` | الـ Router بيعتمد على إن كل الطلبات تروح لـ `index.php` |

البيئات المجرَّبة: **Laragon** (Windows 10/11) و **LAMP** (Linux).

### الخطوات

**1) حمّل المشروع داخل فولدر الويب:**

| البيئة | المسار |
|---|---|
| Laragon | `C:\laragon\www\ecommerce` |
| Linux (LAMP) | `/var/www/html/ecommerce` |

المشروع بيشتغل سواء داخل subfolder (`http://localhost/ecommerce`) أو على الجذر مباشرة (virtual host). الـ subfolder مش شرط.

**2) افتح الـ terminal داخل فولدر المشروع ونفّذ:**

```bash
composer dump-autoload
```

**3) إعدادات قاعدة البيانات** في `config/dataBase.php`:

```php
$host = '127.0.0.1';
$dbname = 'ecommerce';
$username = 'root';
$password = '';
```

الإعدادات الافتراضية دي بتشتغل على Laragon. لو عندك password مختلف عدّله **محلياً فقط ومتعملوش commit** (راجع [قواعد الفريق](#7-قواعد-الفريق)).

**3) شغّل الـ migrations (من جذر المشروع):**

```bash
php migrate.php
```

الأمر ده بيعمل الداتابيز `ecommerce` لو مش موجودة، وبينفذ ملفات `database/migrations/*.php` بالترتيب (001 → 017)، وبيضيف الأدمن الافتراضي.

> ملاحظة: لازم تشغّله من **جذر المشروع** لأن كل المسارات الداخلية نسبية (`./config/...`).
> ملاحظة: الـ migrate مش بيتتبع اللي اتنفذ قبل كده. لو شغلته مرتين على داتابيز موجودة هيفشل عند أول `CREATE TABLE` موجود. لإعادة البناء: امسح الداتابيز `ecommerce` وشغّله من جديد.

**4) افتح المشروع:**

```
http://localhost/ecommerce
```

### بيانات الدخول الافتراضية (Admin)

| الحقل | القيمة |
|---|---|
| Name | `admin` |
| Password | `12345` |

تسجيل دخول الأدمن بيتم بـ **الـ name** مش الـ email.

### ملف `.htaccess`

لازم يكون موجود في جذر المشروع (ملف مخفي ممكن ما يظهرش عندك) ويوجّه أي طلب مش لملف حقيقي إلى `index.php`. الشكل المعتاد:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [L]
```

على Linux لازم `mod_rewrite` مفعّل (`sudo a2enmod rewrite`) و `AllowOverride All` للفولدر.

---

## 2. الـ basePath (مهم جداً)

### المشكلة اللي بيحلها

المشروع ممكن يشتغل من مكان مختلف عند كل واحد فينا:

| مكان المشروع | الرابط الفعلي |
|---|---|
| `www/ecommerce` | `http://localhost/ecommerce/admin` |
| `www/pms-test` | `http://localhost/pms-test/admin` |

لو كتبنا في الكود `href="/admin"` فالمتصفح هيروح لـ `http://localhost/admin` وده غلط، لأن المشروع جوه فولدر. ولو كتبنا `/ecommerce/admin` هيشتغل عندي ويقع عند اللي سمّى الفولدر باسم تاني.

### الحل

`config/rootPath.php` بيحسب 3 قيم في كل طلب ويخزنها في `$GLOBALS`:

| المتغير | معناه | مثال (الرابط `/ecommerce/admin/products/index`) |
|---|---|---|
| `$GLOBALS['basePath']` | فولدر المشروع داخل السيرفر | `/ecommerce` |
| `$GLOBALS['requestUrl']` | الرابط المطلوب **بعد** حذف الـ basePath | `/admin/products/index` |
| `$GLOBALS['previousUrl']` | الصفحة السابقة (من الـ Referer) بعد حذف الـ basePath | `/admin/products/index` |

### القواعد

**1) في `routes/web.php`: اكتب الـ route من غير basePath.** الـ Router بيقارن بالـ `requestUrl` اللي اتشال منه الـ basePath أصلاً.

```php
Main::get('/admin/profile', [...]);        // صح
Main::get('/ecommerce/admin/profile', [...]); // غلط
```

**2) في الـ Views: أي رابط أو `action` أو asset لازم يبدأ بالـ basePath.**

```php
<form action="<?= $GLOBALS['basePath'] ?>/product/store" method="POST">  <!-- صح -->
<form action="/product/store" method="POST">                             <!-- غلط -->
```

**3) في الـ Controllers: أي redirect لازم يبدأ بالـ basePath.**

```php
return header("Location:" . $GLOBALS['basePath'] . "/products/index");   // صح
return header("Location: /products/index");                              // غلط
```

**4) للرجوع للصفحة السابقة استخدم `previousUrl`.** قيمته دايماً بتبدأ بـ `/`:

```php
return header("Location:" . $GLOBALS['basePath'] . $GLOBALS['previousUrl']);
```

> ملاحظة: `previousUrl` معتمد على الـ `Referer` اللي بيبعته المتصفح. لو مش موجود بيرجع `/`.

### لو المشروع شغال من جذر الدومين

المشروع بيشتغل عادي سواء كان داخل subfolder (`http://localhost/ecommerce`) أو على الجذر مباشرة (virtual host أو `localhost`). الـ subfolder مش شرط.

لما المشروع يبقى على الجذر بتبقى `basePath = '/'`، فالروابط اللي بتتركّب بالشكل `basePath . "/path"` ممكن يظهر فيها slashes متكررة (زي `//`). ده شكل طبيعي في المشروع وملوش أثر على التشغيل، فمتقلقش لو لقيت slash زيادة في الرابط.

---

## 3. دورة الطلب (Request Lifecycle)

```
Browser ──► index.php
             ├─ session_start()
             ├─ vendor/autoload.php          (Composer classmap)
             ├─ config/rootPath.php          (basePath / requestUrl / previousUrl)
             ├─ routes/web.php               (يسجّل الـ routes في Main::$routs)
             ├─ core/routing/Main.php
             └─ core/routing/router.php      (يطابق الطلب وينفّذ الكنترولر)
                    │
                    ├─ POST ─► [Request::handle()]  لو فشل: redirect للصفحة السابقة + الأخطاء في $_SESSION
                    │          └─ لو نجح: Controller->method($_POST)
                    │
                    └─ GET  ─► Controller->method([$param])  ─► print_r( القيمة المرجَعة )
                                    │
                                    ├─ Model (HasCrud) ─► PDO ─► MySQL
                                    └─ $this->view('path', $data) ─► resources/views/path.php
```

---

## 4. إضافة Feature جديدة خطوة بخطوة

المثال هنا على **Products** (الـ view `resources/views/admin/index-products.php` جاهز، ومحتاج الـ routes والـ controller).

### الخطوة 0: اعرف الـ view محتاج إيه

افتح الـ view وشوف المتغيرات اللي بيستخدمها والـ `action` بتاع كل form. `index-products.php` مثلاً بيستخدم:

- المتغيرات: `$products` و `$categories`
- الـ forms: `POST /product/store` و `POST /product/update` و `POST /product/delete` (الـ id بيتبعت في hidden input اسمه `id`)

### الخطوة 1: الـ Model

موجود بالفعل في `app/Models`. لو الجدول جديد:

```php
<?php
namespace App\Models;

use core\database\traits\HasCrud;

class Product extends Model
{
    use HasCrud;

    protected string $table = 'products';
}
```

### الخطوة 2: الـ Request (للـ validation)

```php
<?php
namespace App\Http\Requests;

use core\validation\Main;

class ProductStoreRequest extends Main
{
    private function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'min:3', 'max:150'],
            'category_id' => ['required', 'integer'],
            'price'       => ['required', 'numeric'],
            'stock'       => ['required', 'integer'],
        ];
    }

    public function handle(): bool
    {
        return $this->validate($this->rules());
    }
}
```

### الخطوة 3: الـ Controller

```php
<?php
namespace App\Http\Controllers\Admin;

use core\view\Main;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Product();
    }

    // GET: لازم ترجّع الـ view بـ return (مش echo)
    public function index()
    {
        $products   = $this->model->all();
        $categories = (new Category())->all();

        return $this->view('admin/index-products', compact('products', 'categories'));
    }

    // POST: بتاخد $_POST، وبعدها redirect (مش view)
    public function store($data)
    {
        $this->model->insert([
            'category_id' => $data['category_id'],
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'old_price'   => ($data['old_price'] ?? '') !== '' ? $data['old_price'] : null,
            'stock'       => $data['stock'],
            'is_active'   => $data['is_active'],
        ]);

        return header("Location:" . $GLOBALS['basePath'] . "/products/index");
    }

    public function delete($data)
    {
        $this->model->delete($data['id']);

        return header("Location:" . $GLOBALS['basePath'] . "/products/index");
    }
}
```

> الأعمدة فوق مأخوذة من الـ view. **طابقها مع `database/migrations/008_products_table.php`** قبل ما تعتمدها (ممكن فيه أعمدة NOT NULL زيادة).

### الخطوة 4: الـ Routes في `routes/web.php`

```php
use App\Http\Requests\ProductStoreRequest;

Main::get('/products/index', ['Admin\ProductController', 'index']);
Main::post('/product/store',  ['Admin\ProductController', 'store'], ProductStoreRequest::class);
Main::post('/product/delete', ['Admin\ProductController', 'delete']);
```

- أول عنصر في الـ array هو مسار الكنترولر **بعد** `App\Http\Controllers\`، فـ `'Admin\ProductController'` = `App\Http\Controllers\Admin\ProductController`.
- الـ Request class بيتحط كـ argument تالت وهو اختياري، وللـ `POST` فقط.

### الخطوة 5: حدّث الـ autoload

```bash
composer dump-autoload
```

### الخطوة 6: جرّب

افتح `http://localhost/<folder>/products/index` وجرّب الإضافة والحذف.

### route فيه parameter (GET فقط)

```php
Main::get('/products/edit/{id}', ['Admin\ProductController', 'edit']);
```

```php
public function edit($id)   // قيمة {id} بتوصل كـ argument
{
    $product = $this->model->find($id);
    return $this->view('admin/edit-product', compact('product'));
}
```

---

## 5. شرح أجزاء المشروع

### هيكل الفولدرات

```
app/
  Http/Controllers/{Admin,Customer,Storefront}/   الكنترولرز
  Http/Requests/                                  كلاسات الـ validation
  Models/                                         الموديلز
config/
  dataBase.php                                    بيانات الاتصال بالداتابيز
  rootPath.php                                    basePath / requestUrl / previousUrl
core/
  routing/        Main.php (تعريف الـ routes) + router.php (التنفيذ)
  database/       Connection.php + traits/HasCrud.php
  valedation/     Main.php + traits/Validation.php
  view/           Main.php (دالة view)
database/migrations/                              ملفات إنشاء الجداول
public/assets/{admin,user}/                       CSS / JS / صور
resources/views/{admin,user}/                     الـ Views
routes/web.php                                    تعريف كل الـ routes
migrate.php                                       تشغيل الـ migrations
index.php                                         نقطة الدخول الوحيدة
```

### الـ Autoload و Namespaces

المشروع بيستخدم **classmap** في `composer.json` (مش PSR-4). معناه إن Composer بيمسح الفولدرات ويسجل كل كلاس باسمه **المكتوب جوه الملف**، فاسم الفولدر والملف مش بيفرق، لكن:

> **أي كلاس جديد لازم `composer dump-autoload` بعده، وإلا هتظهر `Class not found`.**

الـ namespaces الفعلية (لازم تتكتب بنفس الحروف بالظبط في `use`):

| الجزء | الـ Namespace |
|---|---|
| Controllers | `App\Http\Controllers\{Admin\|Customer\|Storefront}` |
| Requests | `App\Http\Requests` |
| Models | `App\Models` |
| Routing | `Core\Routing\Main` (C كابيتال) |
| Validation | `core\validation\Main` و `core\validation\traits\Validation` |
| View | `core\view\Main` |
| Connection | `App\Core\Database\Connection` |
| HasCrud | `core\database\traits\HasCrud` |

> تنبيه: فيه **3 كلاسات اسمها `Main`** (Routing / Validation / View). خد بالك من الـ `use` أو استخدم alias.

### الـ Router (`core/routing`)

- `Main::get($url, [$controller, $method])`
- `Main::post($url, [$controller, $method], $RequestClass = null)`

| | GET | POST |
|---|---|---|
| Parameters في الرابط | parameter **واحد** بصيغة `{id}` | غير مدعوم (ابعت البيانات في الـ form) |
| Validation | غير مدعوم | Request class كـ argument تالت |
| اللي بيتبعت للميثود | قيمة الـ parameter (لو فيه) | `$_POST` كاملة |
| بعد التنفيذ | `print_r` لقيمة الـ `return` | **ولا حاجة**، الكنترولر لازم يعمل redirect |

قواعد مهمة:

- **أول route يطابق هو اللي بيتنفذ**، فرتّب الـ routes من الأخص للأعم (`/users/create` قبل `/users/{id}`).
- الـ Router بيدعم `GET` و `POST` فقط. الـ update والـ delete بيتعملوا بـ `POST` عادي (والـ id في hidden input).
- ميثود الـ GET لازم **تعمل `return`** للـ view. لو عملت `echo` جواها الترتيب ممكن يبوظ.
- الـ slash في آخر الرابط بيتشال تلقائياً (`/admin/` = `/admin`).
- لو مفيش route مطابق (أو الـ method مختلف) **مفيش صفحة 404**: بتطلع صفحة بيضاء.
- الـ `$_FILES` مش بتتبعت للكنترولر. لو محتاج رفع ملفات استخدم `$_FILES` مباشرة جوه الميثود.

### الـ Controllers

- بيعملوا `extends core\view\Main` عشان ياخدوا دالة `view()`.
- الـ Model بيتعمل في الـ constructor ويتخزن في `$this->model`.
- التنظيم: `Admin/` للوحة التحكم، `Customer/` للعميل بعد تسجيل الدخول، `Storefront/` للصفحات العامة.

### الـ Models و `HasCrud`

```php
class Product extends Model
{
    use HasCrud;
    protected string $table = 'products';
}
```

`Model` بيجهز `$this->db` (اتصال PDO واحد مشترك، Singleton) و `$this->table`.

| الدالة | بترجّع |
|---|---|
| `all()` | array من الصفوف |
| `find($id)` | صف واحد أو `false` |
| `where($column, $operator, $value)` | array من الصفوف (شرط واحد فقط) |
| `insert(array $data)` | `bool` |
| `update($id, array $data)` | `bool` |
| `delete($id)` | `bool` |

- الـ `where` بتقبل العمليات: `= > < >= <= != <>` فقط.
- مفيش `join` أو `orderBy` أو `limit`. لو محتاجهم اكتب ميثود خاصة في الموديل واستخدم `$this->db` (PDO) مباشرة مع prepared statements.
- **أسماء الأعمدة في `insert`/`update` بتتحط في الـ SQL كما هي**، فاتجنب `insert($_POST)` تماماً. ابني الـ array بإيدك عمود عمود (زي ما في الأمثلة)، وإلا هتفتح باب SQL Injection.
- لو محتاج الـ id بتاع آخر سطر اتضاف: `$this->db->lastInsertId()`.

### الـ Validation (`core/valedation`)

بيشتغل على `$_POST` مباشرة. الاستخدام: Request class + تمريرها للـ route (راجع [الخطوة 2](#الخطوة-2-الـ-request-للـ-validation)).

الصيغة: `'rule'` أو `'rule:param1,param2'`.

| القاعدة | الوصف |
|---|---|
| `required` | موجود وغير فارغ |
| `string` / `numeric` / `integer` / `boolean` | نوع القيمة |
| `email` | صيغة إيميل |
| `min:n` / `max:n` | **طول** النص أو عدد عناصر الـ array، أو القيمة لو الرقم مش string |
| `alpha` | حروف فقط (بدون مسافات) |
| `alphaNumeric` | حروف وأرقام فقط |
| `regex:/pattern/` | تعبير نمطي (بدون فاصلة `,` داخله، لأن الفاصلة بتفصل الـ parameters) |
| `confirmed` / `same` | غير شغالين صح حالياً (راجع القيود) |

عند الفشل:

1. بيتخزن في `$_SESSION['valedation'][<field>]` رسالة بالشكل: `The {field} field failed the {rule} rule.` (أول قاعدة فاشلة لكل حقل).
2. بيعمل redirect للصفحة السابقة.
3. الكنترولر **مش بيتنفذ**.

عرض الخطأ في الـ view:

```php
<?php if (!empty($_SESSION['valedation']['name'])): ?>
    <div class="text-danger"><?= htmlspecialchars($_SESSION['valedation']['name']) ?></div>
<?php endif; ?>
```

> الأخطاء **مش بتتمسح تلقائياً** من الـ session. بتتصفّر في بداية أي `validate()` جديد، لكن لو الصفحة اتفتحت بدون validation جديد هتفضل ظاهرة. وكمان القيم القديمة للـ inputs مش بتتحفظ (مفيش `old()`).
> القواعد غير `required` بتعدّي لو الحقل `null` (مش مُرسل)، لكن الحقل المُرسل فاضي `''` بيتفحص عادي.

### الـ Views (`resources/views`)

- ملفات PHP عادية، بتُستدعى من الكنترولر: `$this->view('admin/index-products', compact('products'))`.
- مسار الـ view نسبةً لـ `resources/views` وبدون `.php`.
- المتغيرات لازم تتبعت **كـ associative array** (استخدم `compact()`)، لأن الـ view بيعمل `extract` فكل key بيبقى متغير.
- شكل صفحة الأدمن: بتحدد `$pageTitle` و `$breadcrumbs` في الأول، وبعدين `include` للـ layouts بالترتيب: `head` ← `header` ← `sidebar` ← المحتوى ← `footer` ← `footer-scripts`.
- دايماً `htmlspecialchars()` على أي قيمة جاية من الداتابيز.
- فولدرات `theme/` (في `admin` و `user`) نسخ من القالب الأصلي للرجوع للتصميم، ومش مربوطة بالـ routes.
- الـ assets في `public/assets/admin` و `public/assets/user`، واستخدم الـ basePath في أي مسار ليها.

### الـ Session

`session_start()` بيتعمل مرة واحدة في `index.php`. المفاتيح المستخدمة حالياً:

| المفتاح | الاستخدام |
|---|---|
| `$_SESSION['admin']` | `['logedIn' => true, 'name' => ..., 'id' => ...]` بعد تسجيل دخول الأدمن |
| `$_SESSION['valedation'][field]` | أخطاء الـ validation |
| `$_SESSION['error']['lgoinError']` | خطأ تسجيل دخول الأدمن |
| `$_SESSION['error']['prfilePassword']` | خطأ تغيير الباسورد في بروفايل الأدمن |

> المفاتيح دي فيها أخطاء إملائية (`lgoin`, `prfile`, `valedation`) لكن الـ views معتمدة عليها بنفس الشكل، فمتغيّروهاش إلا لو هتغيّروا الاتنين مع بعض.

### الـ Migrations

- كل ملف في `database/migrations/` بيرجّع **string SQL** أو **array** من الـ statements.
- بيتنفذوا بترتيب الاسم، فالترتيب مهم بسبب الـ foreign keys.
- لإضافة جدول جديد: ملف جديد بالرقم اللي بعده (مثلاً `018_xxx_table.php`) وبعدين `php migrate.php` على داتابيز جديدة.

```php
<?php
return "
    CREATE TABLE IF NOT EXISTS example (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(150) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
```

---

## 6. حل المشاكل الشائعة

| العَرَض | السبب المحتمل | الحل |
|---|---|---|
| `Class "..." not found` | كلاس جديد أو اتغيّر namespace بتاعه | `composer dump-autoload`، وتأكد إن الـ namespace مطابق للـ `use` |
| صفحة بيضاء | الـ route مش معرّف، أو الـ method (GET/POST) مختلف | راجع `web.php`. وفعّل `display_errors` لو فيه خطأ PHP |
| الرابط أو الـ form بيروح مكان غلط | basePath ناقص في الرابط | راجع [الـ basePath](#2-الـ-basepath-مهم-جداً) |
| الصفحة بتفتح بدون CSS أو صور | مسار الـ assets من غير basePath | ضيف `$GLOBALS['basePath']` قبل المسار |
| `SQLSTATE[HY000] [1045] Access denied` | بيانات `config/dataBase.php` غلط | عدّل اليوزر والباسورد محلياً. على Linux غالباً `root` محتاج باسورد أو يوزر مخصص |
| `Unknown database` أو `Table doesn't exist` | الـ migrate ماتشغلش | `php migrate.php` من جذر المشروع |
| `Migration Error: Table ... already exists` | الـ migrate اتشغل قبل كده | امسح الداتابيز `ecommerce` وشغّله من جديد |
| `404` من Apache مش من المشروع | `.htaccess` مش موجود أو `mod_rewrite` مش مفعّل | راجع قسم `.htaccess` |

---

## 7. قواعد الفريق

> القواعد دي مقترحة، عدّلوها حسب اتفاقكم.

- **بعد أي `git pull` فيه كلاسات جديدة: `composer dump-autoload`.**
- اسم الكلاس = اسم الملف، بالـ StudlyCase وإملاء صحيح. **ماتنسخوش الأخطاء القديمة** (`Requst`, `valedation`).
- كل رابط أو redirect أو asset لازم يبدأ بـ `$GLOBALS['basePath']`.
- متستخدمش `insert($_POST)` أبداً. ابني الـ array يدوياً.
- متعملش commit لـ `config/dataBase.php` لو غيّرته لبيئتك.
- ماتغيّرش أسماء مفاتيح الـ session الحالية.
- Feature واحدة = branch واحد.

---

## 8. قيود ومشاكل معروفة

**الـ Router**
- parameter واحد فقط، وللـ `GET` فقط.
- مفيش صفحة 404 (بتطلع صفحة بيضاء).
- مفيش Middleware.
- مفيش `$_FILES` في الـ POST handlers.

**الأمان**
- **مسارات الأدمن (`/admin/...`) غير محمية**: أي حد يقدر يفتحها من غير تسجيل دخول، ومفيش فحص لـ `$_SESSION['admin']` في أي مكان.
- مفيش حماية CSRF.
- جذر المشروع هو الـ DocumentRoot، فملفات زي `migrate.php` و `config/` ممكن تتفتح من المتصفح لو الـ rewrite سمح. **ده لازم يتقفل قبل أي deploy.**

**الـ basePath**
- أماكن الـ redirect مش موحّدة، فممكن تظهر slashes متكررة في الرابط (زي `//`) وده مش بيأثر على التشغيل. الشكل الأنظف: `basePath . previousUrl`.

**الـ Validation**
- `confirmed` و `same` بيقارنوا القيمة بـ **اسم** الحقل الثاني كنص مش بقيمته، فبتفشل دايماً.
- `min`/`max` على القيم الرقمية المبعوتة من الـ form بتتعامل معاها كنص (بتقيس الطول).
- `regex` ماينفعش يحتوي فاصلة `,` (زي `{1,3}`).

**الـ Migrations**
- مش بتتتبع اللي اتنفذ، فمش آمن تشغيلها مرتين.
- ملف `001_users_table.php` بيستخدم `CREATE TABLE` بدون `IF NOT EXISTS` (راجع باقي الملفات).

**كود محتاج مراجعة**
- `AdminController::index` بيرجّع بيانات ثابتة (hardcoded) بدل `$this->model->all()`.
- `AdminController::profileUpdate`: لو الباسورد القديم غلط مفيش أي تحديث ولا رسالة للمستخدم.
- `AdminController::login`: لو الاسم مش موجود بيحصل `Undefined array key 0`.
- أخطاء إملائية في أسماء ملفات وفولدرات ومفاتيح: `valedation`, `Requst`, `lgoinError`, `prfilePassword`.
- Routes الـ CRUD (products / categories / orders / users / admins) لسه غير معرّفة، والـ views بتاعتها جاهزة.
- ما فيش route مُعرَّف لعرض صفحة تسجيل دخول الأدمن (`admin/auth/login.php`) ولا لـ `AdminController::logout` و `store`.
