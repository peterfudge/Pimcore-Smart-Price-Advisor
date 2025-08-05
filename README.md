# Pimcore Smart Price Advisor
## SmartPriceAdvisorBundle

SmartPriceAdvisorBundle is a custom Pimcore extension that integrates OpenAI's GPT-4 to analyze and recommend competitive pricing strategies for products based on real-time product metadata.

---

## 🚀 Features

- Adds a "Run SmartPrice Advisor" button to Pimcore Product objects.
- Sends product metadata to OpenAI GPT-4 for competitive pricing evaluation.
- Displays AI-generated competitor pricing comparisons, recommended price, and rationale.
- Built using Symfony services and Pimcore extension best practices.

---

## 📁 File Structure

```txt
SmartPriceAdvisorBundle/
├── Controller/
│   └── AdminController.php
├── DependencyInjection/
│   └── SmartPriceAdvisorExtension.php
├── Resources/
│   ├── config/
│   │   └── services.yaml
│   ├── public/
│   │   └── js/
│   │       └── admin.js
│   └── views/
│       └── admin/
│           └── smartprice-modal.html.twig
├── Service/
│   └── GPTPricingAdvisor.php
├── SmartPriceAdvisorBundle.php
└── README.md
```

---

## ⚙️ Installation

1. Clone or copy the bundle to `src/SmartPriceAdvisorBundle`

2. Register it in `config/bundles.php`:
```php
SmartPriceAdvisorBundle\SmartPriceAdvisorBundle::class => ['all' => true],
```

3. Add autoloading to `composer.json`:
```json
"autoload": {
  "psr-4": {
    "SmartPriceAdvisorBundle\\": "src/SmartPriceAdvisorBundle/"
  }
}
```

4. Dump autoload:
```bash
composer dump-autoload
```

5. Add OpenAI API Key to `.env.local`:
```dotenv
OPENAI_API_KEY=your_api_key_here
```

6. Clear and warm Symfony cache:
```bash
bin/console cache:clear
bin/console cache:warmup
```

---

## 🧠 How It Works

1. Open a Product object in Pimcore admin.
2. Click the "Run SmartPrice Advisor" button in the toolbar.
3. A modal appears with a loading message.
4. The backend sends the product data (brand, model, UPC, category, price) to OpenAI GPT-4.
5. The AI returns:
   - A list of competitors and their pricing
   - A recommended price for your store
   - A short rationale
6. The modal displays this response as a preformatted block.

---

## 🛠 Customization

- **Prompt logic**: Modify `GPTPricingAdvisor::buildPrompt()` to tailor AI instructions.
- **UI modal**: Update `smartprice-modal.html.twig` for custom display.
- **Data mapping**: Ensure your Product class has fields `brand`, `modelNumber`, `upc`, `category`, `price`.

---

## ✅ Requirements

- Pimcore 10+
- PHP 8.1+
- `pdo_mysql` and `dom` PHP extensions
- Guzzle HTTP client (usually included by Pimcore)

---

## 📄 License

MIT License. Use at your own risk. OpenAI API usage may incur costs.

---

## 👋 Author

Peter Fudge · [linkedin.com/in/peterfudge](https://linkedin.com/in/peterfudge)
