# E-commerce Project — PHP MVC

مشروع متجر إلكتروني مكتوب بـ PHP بدون Framework، بيطبّق مبدأ **MVC** و **OOP**، وبيستخدم Router شبيه بـ Laravel لكن أبسط وبقيود مختلفة (موضحة في الأسفل).

> **لو أول مرة تفتح المشروع:** اقرأ قسم [التشغيل](#1-التشغيل) وبعده قسم [الـ basePath](#2-الـ-basepath-مهم-جداً)، الاتنين دول هما أكتر سبب لمشاكل "الصفحة مش بتفتح / الرابط بيروح مكان غلط".

---

## المحتويات

> **لو هتشتغل على CRUD:** اقرأ التشغيل والـ basePath، وبعدها روح مباشرة لقسم [دليل CRUD كامل](#6-دليل-crud-كامل-مع-validation).

1. [التشغيل](#1-التشغيل)
2. [الـ basePath (مهم جداً)](#2-الـ-basepath-مهم-جداً)
3. [دورة الطلب (Request Lifecycle)](#3-دورة-الطلب-request-lifecycle)
4. [شرح أجزاء المشروع](#4-شرح-أجزاء-المشروع)
5. [حل المشاكل الشائعة](#5-حل-المشاكل-الشائعة)
6. [دليل CRUD كامل مع Validation](#6-دليل-crud-كامل-مع-validation)

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

الإعدادات الافتراضية دي بتشتغل على Laragon. لو عندك password مختلف عدّله **محلياً فقط ومتعملوش commit**.

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

## 4. شرح أجزاء المشروع

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

### الـ Models و `HasCrud`

الموديل = كلاس بيمثل **جدول واحد** في الداتابيز. شكله:

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

| الجزء | وظيفته |
|---|---|
| `namespace App\Models` | لازم يطابق الـ `use` في الكنترولر |
| `extends Model` | `Model` كلاس abstract بيجهز `$this->db` (اتصال PDO) في الـ constructor. الاتصال Singleton: اتصال واحد بيتشارك بين كل الموديلز في الطلب الواحد |
| `use HasCrud` | بيضيف الدوال الجاهزة (`all`, `find`, `where`, `insert`, `update`, `delete`) |
| `protected string $table` | اسم الجدول، بيتحط في كل query. لازم يطابق اسم الجدول في الـ migration |

**لعمل موديل جديد:** (1) migration للجدول (2) ملف الموديل في `app/Models` بنفس الشكل فوق (3) `composer dump-autoload`.

الاستخدام من الكنترولر:

```php
$this->model = new Product();      // في الـ constructor
$products = $this->model->all();   // في أي ميثود
```

#### دوال `HasCrud` (كلها بتتنادى على الـ object: `$this->model->...`)

**`all()`: كل الصفوف**

```php
$products = $this->model->all();
// [ ['id' => 1, 'name' => 'Shirt', ...], ['id' => 2, ...] ]
// لو الجدول فاضي بترجع [] (array فاضي)
```

بدون ترتيب أو limit.

**`find($id)`: صف واحد بالـ id**

```php
$product = $this->model->find(5);

if (!$product) {
    // مش موجود (بترجع false)
}

echo $product['name'];   // الصف array بمفاتيح أسماء الأعمدة
```

**`where($column, $operator, $value)`: صفوف بشرط واحد**

```php
$active   = $this->model->where('is_active', '=', 1);
$lowStock = $this->model->where('stock', '<', 5);

// أول نتيجة فقط (مثال تسجيل الدخول)
$admins = $this->model->where('name', '=', $data['name']);
$admin  = $admins[0] ?? null;
```

- بترجع **array دايماً** (ممكن فاضي)، حتى لو النتيجة صف واحد، فالصف الأول هو `[0]`.
- العمليات المسموحة: `=` `>` `<` `>=` `<=` `!=` `<>`. غيرها بيرمي `InvalidArgumentException`.
- اسم العمود حروف وأرقام و `_` فقط.
- شرط واحد بس (مفيش AND / OR).

**`insert(array $data)`: إضافة صف**

```php
$this->model->insert([
    'name'  => $data['name'],
    'price' => $data['price'],
    'stock' => $data['stock'],
]);
```

- مفاتيح الـ array = أسماء الأعمدة، والقيم = البيانات (القيم بتتبعت بـ prepared statement).
- بترجع `bool`.
- لازم تبعت كل الأعمدة اللي NOT NULL وملهاش default.
- **أسماء الأعمدة بتتحط في الـ SQL كما هي**، فمتعملش `insert($_POST)` أبداً. ابني الـ array بإيدك عمود عمود.

**`update($id, array $data)`: تعديل صف**

```php
$this->model->update(5, [
    'price' => 120,
    'stock' => 30,
]);
```

- بيحدّث الأعمدة المبعوتة فقط (`WHERE id = ?`).
- بترجع `bool`.
- نفس تحذير الأعمدة في `insert`.

**`delete($id)`: حذف صف**

```php
$this->model->delete(5);
```

بترجع `bool`. لو الصف مربوط بجداول تانية بـ foreign key ممكن الحذف يفشل برمي `PDOException`.

> أي خطأ من الداتابيز (مثلاً إيميل مكرر على عمود `UNIQUE`) بيرمي `PDOException` لأن الاتصال شغال بـ `ERRMODE_EXCEPTION`.

#### Query مخصص (join / order / limit / lastInsertId)

`HasCrud` مفيهاش join أو ترتيب. اكتب ميثود خاصة **داخل الموديل** واستخدم `$this->db` (PDO) مباشرة، ودايماً بـ prepared statements:

```php
class Product extends Model
{
    use HasCrud;

    protected string $table = 'products';

    // join + order
    public function allWithCategory(): array
    {
        $stmt = $this->db->query(
            "SELECT p.*, c.name AS category_name
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             ORDER BY p.id DESC"
        );

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // query فيه قيمة جاية من المستخدم
    public function lowerThan(int $stock): array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE stock < ?");
        $stmt->execute([$stock]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // إضافة وإرجاع الـ id الجديد
    public function create(array $data): int
    {
        $this->insert($data);

        return (int) $this->db->lastInsertId();
    }
}
```

`$this->db` هو `protected`، يعني بيتستخدم جوه الموديل بس، مش من الكنترولر.

### الـ Controllers

الكنترولر هو اللي بيستقبل الطلب من الـ Router وبيكلّم الموديل وبيرجّع view أو بيعمل redirect.

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

    // GET /products/index
    public function index()
    {
        $products   = $this->model->all();
        $categories = (new Category())->all();   // موديل تاني

        return $this->view('admin/index-products', compact('products', 'categories'));
    }

    // POST /product/store
    public function store($data)
    {
        $this->model->insert([ /* ... */ ]);

        return header("Location:" . $GLOBALS['basePath'] . "/products/index");
    }
}
```

| الجزء | الشرح |
|---|---|
| `namespace` | لازم يطابق مكان الملف. في الـ route بتكتبه نسبةً لـ `App\Http\Controllers\` فقط: `'Admin\ProductController'` |
| `extends Main` | `Main` هنا هو `core\view\Main`، وبيدّيك دالة `$this->view()` |
| `public object $model` + `__construct` | الـ Router بيعمل `new Controller()` **من غير arguments**، فأي تجهيز (زي إنشاء الموديل) بيتم في الـ constructor |
| الـ public methods | كل ميثود بتتربط بـ route واحد (أو أكتر) في `web.php` |
| ميثود GET | بتاخد الـ parameter (`$id`) لو الـ route فيه `{id}`، وبتعمل **`return`** لـ `$this->view(...)` (الـ Router هو اللي بيطبع القيمة) |
| ميثود POST | بتاخد `$data` (= `$_POST` كاملة)، وبتنتهي بـ **redirect**. لو رجّعت view من POST مش هيتطبع |
| الـ redirect | `header("Location:" . $GLOBALS['basePath'] . "/path")` |
| ميثود `private` | دوال مساعدة داخلية مش مربوطة بأي route |
| الـ Session | `$_SESSION` متاح في أي ميثود (راجع قسم Session) |

`$this->view('admin/index-products', compact('products', 'categories'))`: الأول مسار الـ view نسبةً لـ `resources/views` وبدون `.php`، والتاني array المتغيرات اللي هتوصل للـ view.

### الـ Validation (`core/valedation`)

#### الفكرة

لكل form بتعمل **Request class** فيه قواعد كل حقل، وبتربطه بالـ route كـ argument تالت. الـ Router بينفذ الـ validation **قبل** الكنترولر.

```php
<?php
namespace App\Http\Requests;

use core\validation\Main;

class ProductStoreRequest extends Main
{
    private function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'min:3', 'max:150'],
            'price' => ['required', 'numeric'],
        ];
    }

    public function handle(): bool
    {
        return $this->validate($this->rules());
    }
}
```

```php
// routes/web.php
use App\Http\Requests\ProductStoreRequest;

Main::post('/product/store', ['Admin\ProductController', 'store'], ProductStoreRequest::class);
```

- `rules()` بترجع array: **اسم الحقل (نفس `name` في الـ form)** => array من القواعد.
- `handle()` لازم تكون `public` وترجّع `bool`، والـ Router هو اللي بينادي عليها.
- القيم بتتقرأ من `$_POST` مباشرة.
- الصيغة: `'rule'` أو `'rule:param'` أو `'rule:param1,param2'`.

#### كل القواعد المتاحة

| القاعدة | بتنجح لما | مثال في `rules()` | أمثلة قيم |
|---|---|---|---|
| `required` | الحقل موجود وغير فاضي (ومش مسافات بس) | `'name' => ['required']` | `'Ali'` ينجح، `''` أو `'   '` يفشل |
| `string` | القيمة نص | `'name' => ['string']` | قيم الـ forms كلها نصوص، فبتنجح تقريباً دايماً |
| `numeric` | رقم صحيح أو عشري | `'price' => ['required', 'numeric']` | `'10'` و `'10.5'` ينجحوا، `'abc'` و `''` يفشلوا |
| `integer` | رقم صحيح | `'stock' => ['required', 'integer']` | `'5'` ينجح، `'5.5'` و `''` يفشلوا |
| `boolean` | `0` أو `1` فقط | `'is_active' => ['boolean']` | `'0'` و `'1'` ينجحوا، `'yes'` يفشل |
| `email` | صيغة إيميل صحيحة | `'email' => ['required', 'email']` | `'a@b.com'` ينجح، `'a@b'` و `''` يفشلوا |
| `min:n` | **طول** النص على الأقل n | `'password' => ['required', 'min:8']` | `min:8`: `'12345678'` ينجح، `'1234'` يفشل |
| `max:n` | طول النص على الأكثر n | `'name' => ['max:150']` | `max:5`: `'abcde'` ينجح، `'abcdef'` يفشل |
| `alpha` | حروف فقط (عربي وإنجليزي)، بدون مسافات أو أرقام | `'name' => ['alpha']` | `'Mohamed'` ينجح، `'Mohamed Ali'` و `'Ali2'` يفشلوا |
| `alphaNumeric` | حروف وأرقام فقط، بدون مسافات | `'code' => ['alphaNumeric']` | `'AB12'` ينجح، `'AB 12'` يفشل |
| `regex:/pattern/` | القيمة تطابق التعبير النمطي (بالـ delimiters) | `'phone' => ['regex:/^01[0-9]{9}$/']` | `'01012345678'` ينجح، `'12345'` يفشل |
| `confirmed:field` و `same:field` | **مش شغالين حالياً** | | بيقارنوا بنص اسم الحقل مش بقيمته، فبيفشلوا دايماً. متستخدموهمش لحد ما يتعدلوا |

ملاحظات على القواعد:

- `min` و `max` بيقيسوا **طول النص** حتى لو الحقل رقم (قيم الـ form كلها نصوص). عشان تتأكد إن القيمة رقم استخدم `numeric` أو `integer` مش `min`.
- الـ `regex` ماينفعش يحتوي فاصلة `,` لأنها بتفصل الـ parameters. فمثلاً `{1,3}` ممنوعة، واستخدم `{3}` أو `+` أو `*`.
- `min:8` بتتكتب مرة واحدة والرقم بعد `:`، ومفيش مسافات.

#### قواعد التنفيذ (مهمة)

1. القواعد بتتفحص **بالترتيب**، وأول قاعدة تفشل بتوقف باقي قواعد نفس الحقل. فحط `required` الأول.
2. القواعد غير `required` بتنجح لو الحقل **غير مُرسل** (`null`). فلو الحقل إجباري لازم تحط `required`.
3. لو الحقل **مُرسل فاضي** (`''`) بيتفحص عادي، و`''` بتفشل `numeric` و `integer` و `email` و `boolean`. فالحقل **الاختياري** اللي ممكن يتبعت فاضي (زي `old_price` في form المنتجات) **متحطش عليه** القواعد دي.
4. أي حقل مالوش قواعد في `rules()` مش بيتفحص خالص.
5. لو اسم القاعدة مش موجود بيرمي `InvalidArgumentException`.

#### لما الـ validation يفشل

1. الكنترولر **مش بيتنفذ**.
2. بيتخزن لكل حقل فشل رسالة في `$_SESSION['valedation'][<field>]` بالشكل: `The price field failed the numeric rule.`
3. المستخدم بيرجع للصفحة السابقة (redirect لـ `previousUrl`).

الـ session بتتصفّر في بداية أي `validate()` جديد، لكن مش بتتمسح لوحدها بعد العرض.

عرض الأخطاء في الـ view **اختياري** (الـ CRUD بيشتغل من غيره):

```php
<?php if (!empty($_SESSION['valedation'])): ?>
    <div class="alert alert-danger">
        <?php foreach ($_SESSION['valedation'] as $message): ?>
            <div><?= htmlspecialchars($message) ?></div>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['valedation']); ?>
<?php endif; ?>
```

#### إضافة قاعدة جديدة

اسم القاعدة = اسم ميثود في `core/valedation/traits/Validation.php`. أول parameter هو القيمة، وبعده الـ parameters اللي بعد `:`. لازم ترجّع `bool`:

```php
public function startsWith($value, string $prefix): bool
{
    return $value === null || str_starts_with($value, $prefix);
}
```

```php
'phone' => ['required', 'startsWith:01'],
```

### الـ Views (`resources/views`)

- **الـ Views جاهزة بالكامل ومش ناقصها حاجة.** أي حد يشتغل على CRUD مطلوب منه الـ routes والكنترولر (والـ Request) فقط، ومش محتاج يعدّل أو يضيف ملفات view.
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

## 5. حل المشاكل الشائعة

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

---

## 6. دليل CRUD كامل مع Validation

**الـ Views بتاعة لوحة الأدمن كاملة ومش ناقصها حاجة** (الجداول، ومودالات الإضافة والتعديل والحذف، والـ JavaScript اللي بيملا الـ id وباقي القيم). ولا فيه حاجة محتاجة تتعمل في الـ views.
اللي ناقص فعلاً وهو شغلك: **Routes + Controller methods + Request classes**. والـ Models موجودة بالفعل في `app/Models`.

المثال هنا على **Products**، والخطوات نفسها بتتكرر لأي جدول تاني (Categories / Users / Orders / Admins).

### الخطوة 1: اقرأ الـ view

افتح الـ view (`resources/views/admin/index-products.php`) وسجّل 3 حاجات: المتغيرات اللي بيستخدمها، والـ `action` لكل form، وأسماء الحقول (`name="..."`):

| من الـ view | القيمة |
|---|---|
| المتغيرات | `$products` و `$categories` |
| صفحة العرض | `GET /products/index` |
| form الإضافة | `POST /product/store` وحقوله: `name`, `category_id`, `description`, `price`, `old_price`, `stock`, `is_active` |
| form التعديل | `POST /product/update` ونفس الحقول + `id` |
| form الحذف | `POST /product/delete` وحقله: `id` |

كل form بيبعت `id` في hidden input (راجع شرح الـ delete)، فمفيش route فيه `{id}` ومفيش صفحة تعديل منفصلة: التعديل والحذف بيتم من مودالات في نفس الصفحة.

### الخطوة 2: الـ Request classes (الـ validation)

`app/Http/Requests/ProductStoreRequest.php`:

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
            'is_active'   => ['boolean'],
            // description و old_price اختياريين ويتبعتوا فاضيين '' فمفيش عليهم قواعد
        ];
    }

    public function handle(): bool
    {
        return $this->validate($this->rules());
    }
}
```

`app/Http/Requests/ProductUpdateRequest.php`: نفس الشكل بنفس القواعد + الـ id:

```php
<?php
namespace App\Http\Requests;

use core\validation\Main;

class ProductUpdateRequest extends Main
{
    private function rules(): array
    {
        return [
            'id'          => ['required', 'integer'],
            'name'        => ['required', 'string', 'min:3', 'max:150'],
            'category_id' => ['required', 'integer'],
            'price'       => ['required', 'numeric'],
            'stock'       => ['required', 'integer'],
            'is_active'   => ['boolean'],
        ];
    }

    public function handle(): bool
    {
        return $this->validate($this->rules());
    }
}
```

الحذف مش محتاج Request (الـ id جاي من hidden input). لو عايز تتأكد منه اعمل `ProductDeleteRequest` بقاعدة `'id' => ['required', 'integer']`.

### الخطوة 3: الـ Controller

`app/Http/Controllers/Admin/ProductController.php`:

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

    // READ: GET /products/index
    public function index()
    {
        $products   = $this->model->all();
        $categories = (new Category())->all();

        return $this->view('admin/index-products', compact('products', 'categories'));
    }

    // CREATE: POST /product/store
    public function store($data)
    {
        $this->model->insert($this->fields($data));

        return header("Location:" . $GLOBALS['basePath'] . "/products/index");
    }

    // UPDATE: POST /product/update
    public function update($data)
    {
        $this->model->update($data['id'], $this->fields($data));

        return header("Location:" . $GLOBALS['basePath'] . "/products/index");
    }

    // DELETE: POST /product/delete
    public function delete($data)
    {
        $this->model->delete($data['id']);

        return header("Location:" . $GLOBALS['basePath'] . "/products/index");
    }

    // دالة مساعدة (مش مربوطة بـ route): بتجهز الأعمدة يدوياً للـ insert والـ update
    private function fields(array $data): array
    {
        return [
            'category_id' => $data['category_id'],
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'old_price'   => ($data['old_price'] ?? '') !== '' ? $data['old_price'] : null,
            'stock'       => $data['stock'],
            'is_active'   => $data['is_active'],
        ];
    }
}
```

- `old_price` الفاضي بيتحول لـ `null` عشان عمود الأرقام ميرفضش `''`.
- **طابق الأعمدة في `fields()` مع `database/migrations/008_products_table.php`** قبل ما تعتمدها (ممكن فيه أعمدة NOT NULL تانية).

### الخطوة 4: الـ Routes

في `routes/web.php`، ضيف الـ `use` فوق، والـ routes مع باقي الـ routes:

```php
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

Main::get('/products/index',  ['Admin\ProductController', 'index']);   // موجود بالفعل
Main::post('/product/store',  ['Admin\ProductController', 'store'],  ProductStoreRequest::class);
Main::post('/product/update', ['Admin\ProductController', 'update'], ProductUpdateRequest::class);
Main::post('/product/delete', ['Admin\ProductController', 'delete']);
```

### الخطوة 5: حدّث الـ autoload

```bash
composer dump-autoload
```

لأن في كلاسات جديدة (الـ Requests والـ Controller).

### الخطوة 6: جرّب

- افتح `/products/index` ولازم الجدول يظهر.
- **إضافة**: املا الـ form وابعت، المنتج يظهر في الجدول.
- **Validation**: ابعت اسم من حرفين أو سعر `abc`، المفروض ترجع للصفحة من غير ما يتضاف حاجة.
- **تعديل**: اضغط أيقونة التعديل، غيّر قيمة، احفظ.
- **حذف**: اضغط أيقونة الحذف وأكّد.

### ملخص: العملية بتمشي إزاي

| العملية | Route | Request | ميثود الكنترولر | ميثود الموديل |
|---|---|---|---|---|
| عرض | `GET /products/index` | لا | `index()` | `all()` |
| إضافة | `POST /product/store` | `ProductStoreRequest` | `store($data)` | `insert()` |
| تعديل | `POST /product/update` | `ProductUpdateRequest` | `update($data)` | `update()` |
| حذف | `POST /product/delete` | لا | `delete($data)` | `delete()` |

### لتكرار الخطوات على جدول تاني

1. افتح الـ view بتاعه وسجّل: المتغيرات، وكل `action`، وأسماء الحقول.
2. تأكد إن الموديل موجود في `app/Models` (وإلا اعمله).
3. اعمل Request لكل form ليه حقول محتاجة تتفحص.
4. اعمل الكنترولر بنفس شكل `ProductController` (نفس الأربع ميثودز).
5. سجّل الـ routes **بنفس الـ URLs اللي في الـ forms بالظبط**.
6. `composer dump-autoload` وجرّب.

### route فيه parameter في الرابط (لو احتجته)

الـ GET بس بيدعم parameter واحد بصيغة `{id}`:

```php
Main::get('/products/show/{id}', ['Admin\ProductController', 'show']);
```

```php
public function show($id)   // قيمة {id} بتوصل كـ argument
{
    $product = $this->model->find($id);

    return $this->view('admin/show-product', compact('product'));
}
```
