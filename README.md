# SalesPaymentMerchantSalesMerchantCommission Module
[![Latest Stable Version](https://poser.pugx.org/spryker/sales-payment-merchant-sales-merchant-commission/v/stable.svg)](https://packagist.org/packages/spryker/sales-payment-merchant-sales-merchant-commission)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.3-8892BF.svg)](https://php.net/)

The SalesPaymentMerchantSalesMerchantCommission module provides functionality for calculating payout amounts and reverse payout amounts for merchant sales payments.
This module is essential for managing financial transactions between merchants and the marketplace, ensuring accurate payment processing according to predefined commission rates.

## Installation

```
composer require spryker/sales-payment-merchant-sales-merchant-commission
```

## Documentation

[Spryker Documentation](https://docs.spryker.com)


## Key Concepts

| Term | Meaning |
| --- | --- |
| **GMV** | Gross Merchandise Value --- what the customer pays |
| **Commission** | Marketplace fee charged to the merchant |
| **VAT/GST** | Tax on the sale of goods |
| **Withholding Tax** | Tax the marketplace retains on behalf of the merchant |
| **Tax Agent** | When the marketplace is legally obligated to collect & remit tax |
| **GROSS mode** | Prices displayed include tax |
| **NET mode** | Prices displayed exclude tax |

* * * * *

Use Case 1 --- Germany (GROSS Mode, Marketplace is NOT a Tax Agent)
---------------------------------------------------------------------

**The most common EU B2C model.** The merchant is responsible for their own VAT. The marketplace simply deducts commission and pays out the rest.

> 🇩🇪 German VAT = **19%**

### Example: Product price €119.00 (GROSS, VAT included)


| Step | Calculation | Amount |
| --- | --- | --- |
| Customer pays |  | **€119.00** |
| VAT included in price | €119.00 / 1.19 × 0.19 | €19.00 |
| Net product price (excl. VAT) | €119.00 - €19.00 | €100.00 |
| Marketplace commission (15% on GMV) | €119.00 × 0.15 | €17.85 |
| VAT on commission (19%) | €17.85 / 1.19 × 0.19 | €2.85 |
| **Payout to merchant** | €119.00 - €17.85 | **€101.15** |

**What happens with taxes:**

-   The **merchant** reports and remits the full €19.00 VAT on the sale to the tax authority.
-   The merchant receives a commission invoice from the marketplace (€17.85 incl. VAT) and can deduct the €2.85 VAT as input tax.
-   **Marketplace does NOT act as tax agent** --- it just facilitates.

* * * * *

Use Case 2 --- Germany (GROSS Mode, Marketplace IS a Deemed Supplier / Tax Agent)
-----------------------------------------------------------------------------------

Under **EU 2021 e-commerce rules**, if the merchant is **non-EU** (e.g., a Chinese seller), the marketplace becomes the **deemed supplier** and must collect & remit VAT.

> 🇩🇪 VAT = **19%**, non-EU merchant

### Example: Product price €119.00 (GROSS)


| Step | Calculation | Amount |
| --- | --- | --- |
| Customer pays |  | **€119.00** |
| VAT (marketplace must remit) | €119.00 / 1.19 × 0.19 | €19.00 |
| Net sale value |  | €100.00 |
| Marketplace commission (15% on net) | €100.00 × 0.15 | €15.00 |
| **Marketplace retains** | VAT + Commission = €19.00 + €15.00 | **€34.00** |
| **Payout to merchant** | €119.00 - €34.00 | **€85.00** |

**What happens with taxes:**

-   **Marketplace** remits €19.00 VAT to the German tax authority (Finanzamt).
-   Merchant receives €85.00 --- no VAT obligation in Germany.
-   Marketplace issues a self-billing invoice to the merchant.

* * * * *

Use Case 3 --- United Kingdom (GROSS Mode, Marketplace as Tax Agent for Non-UK Sellers)
-----------------------------------------------------------------------------------------

Since Brexit, UK requires marketplaces to collect VAT on goods ≤ £135 sold by **overseas sellers**.

> 🇬🇧 UK VAT = **20%**

### Example: Product price £120.00 (GROSS, VAT included)


| Step | Calculation | Amount |
| --- | --- | --- |
| Customer pays |  | **£120.00** |
| VAT (marketplace collects) | £120.00 / 1.20 × 0.20 | £20.00 |
| Net sale value |  | £100.00 |
| Marketplace commission (12% on net) | £100.00 × 0.12 | £12.00 |
| **Marketplace retains** | £20.00 + £12.00 | **£32.00** |
| **Payout to merchant** | £120.00 - £32.00 | **£88.00** |

For a **domestic UK seller**, the marketplace does NOT withhold VAT --- same as Use Case 1 (Germany, no tax agent).

* * * * *

Use Case 4 --- United States (NET Mode, Sales Tax Collected by Marketplace)
-----------------------------------------------------------------------------

Most US states have **Marketplace Facilitator Laws** --- the marketplace **must** collect and remit sales tax regardless of merchant origin.

> 🇺🇸 Example: California sales tax = **7.25%** (can be higher with local taxes, e.g., 9.5% in LA)

### Example: Product price $100.00 (NET, tax excluded), LA rate 9.5%


| Step | Calculation | Amount |
| --- | --- | --- |
| Product price (NET) |  | $100.00 |
| Sales tax (marketplace collects) | $100.00 × 0.095 | $9.50 |
| Customer pays | $100.00 + $9.50 | **$109.50** |
| Marketplace commission (15% on product price) | $100.00 × 0.15 | $15.00 |
| **Marketplace retains** | Sales tax + Commission = $9.50 + $15.00 | **$24.50** |
| **Payout to merchant** | $109.50 - $24.50 | **$85.00** |

**Key point:** In the US, sales tax is **never** part of the merchant's payout --- the marketplace handles it entirely.

* * * * *

Use Case 5 --- India (NET Mode, TDS + GST)
--------------------------------------------

India has a unique system: marketplaces must deduct **TDS (Tax Deducted at Source)** at **1%** on net sales AND collect **GST**.

> 🇮🇳 GST = **18%** (standard rate), TDS = **1%**

### Example: Product price ₹1,000 (NET)


| Step | Calculation | Amount |
| --- | --- | --- |
| Product price (NET) |  | ₹1,000 |
| GST (collected from buyer) | ₹1,000 × 0.18 | ₹180 |
| Customer pays |  | **₹1,180** |
| Marketplace commission (20% on net) | ₹1,000 × 0.20 | ₹200 |
| GST on commission (18%) | ₹200 × 0.18 | ₹36 |
| TDS (1% on net sale) | ₹1,000 × 0.01 | ₹10 |
| **Marketplace retains** | Commission + GST on commission + TDS = ₹200 + ₹36 + ₹10 | **₹246** |
| **Payout to merchant** | ₹1,180 - ₹246 | **₹934** |

**What happens:**

-   Marketplace remits ₹10 TDS to the Income Tax Department (merchant claims credit).
-   Merchant remits GST of ₹180 but claims ₹36 input credit on commission → net GST liability = ₹144.

* * * * *

Use Case 6 --- Australia (GROSS Mode, GST Withholding for Non-Resident Sellers)
---------------------------------------------------------------------------------

> 🇦🇺 GST = **10%**

### Example: Product price AUD 110.00 (GROSS), non-resident merchant


| Step | Calculation | Amount |
| --- | --- | --- |
| Customer pays |  | **AUD 110.00** |
| GST (marketplace collects for non-resident) | AUD 110.00 / 1.10 × 0.10 | AUD 10.00 |
| Net sale |  | AUD 100.00 |
| Marketplace commission (10% on net) | AUD 100.00 × 0.10 | AUD 10.00 |
| **Marketplace retains** | AUD 10.00 + AUD 10.00 | **AUD 20.00** |
| **Payout to merchant** | AUD 110.00 - AUD 20.00 | **AUD 90.00** |

* * * * *

Use Case 7 --- Japan (Consumption Tax, Invoice System since Oct 2023)
-----------------------------------------------------------------------

> 🇯🇵 Consumption Tax (JCT) = **10%**

### Example: Product price ¥11,000 (GROSS, tax included), domestic seller


| Step | Calculation | Amount |
| --- | --- | --- |
| Customer pays |  | **¥11,000** |
| JCT included | ¥11,000 / 1.10 × 0.10 | ¥1,000 |
| Marketplace commission (10% on GMV) | ¥11,000 × 0.10 | ¥1,100 |
| JCT on commission | ¥1,100 / 1.10 × 0.10 | ¥100 |
| **Payout to merchant** | ¥11,000 - ¥1,100 | **¥9,900** |

Merchant remits ¥1,000 JCT but deducts ¥100 input credit → net ¥900 to tax authority.

* * * * *

Use Case 8 --- Brazil (Complex Multi-Tax, Marketplace Withholding)
--------------------------------------------------------------------

Brazil has one of the most complex systems with multiple overlapping taxes.

> 🇧🇷 ICMS ≈ **18%**, PIS/COFINS ≈ **9.25%**, ISS on services ≈ **5%**

### Example: Product price R$100.00 (NET), simplified


| Step | Calculation | Amount |
| --- | --- | --- |
| Product price |  | R$100.00 |
| ICMS (included in price, state tax) | R$100.00 × 0.18 | R$18.00 |
| Customer pays |  | **R$100.00** |
| Marketplace commission (15%) | R$100.00 × 0.15 | R$15.00 |
| ISS on commission (5%) | R$15.00 × 0.05 | R$0.75 |
| Withholding taxes (IR, PIS, COFINS, CSLL ≈ 5.85%) | R$100.00 × 0.0585 | R$5.85 |
| **Marketplace retains** | R$15.00 + R$0.75 + R$5.85 | **R$21.60** |
| **Payout to merchant** | R$100.00 - R$21.60 | **R$78.40** |

* * * * *

Summary Matrix
--------------


| Country | Price Mode | Marketplace as Tax Agent? | What Marketplace Withholds | Merchant Receives |
| --- | --- | --- | --- | --- |
| 🇩🇪 Germany (EU seller) | GROSS | ❌ No | Commission only | GMV - Commission |
| 🇩🇪 Germany (non-EU seller) | GROSS | ✅ Yes (deemed supplier) | VAT + Commission | GMV - VAT - Commission |
| 🇬🇧 UK (overseas, ≤£135) | GROSS | ✅ Yes | VAT + Commission | GMV - VAT - Commission |
| 🇺🇸 USA | NET | ✅ Yes (facilitator) | Sales Tax + Commission | GMV + Tax - Tax - Commission |
| 🇮🇳 India | NET | ✅ Partial (TDS) | Commission + GST on commission + TDS | GMV - all deductions |
| 🇦🇺 Australia (non-resident) | GROSS | ✅ Yes | GST + Commission | GMV - GST - Commission |
| 🇯🇵 Japan (domestic) | GROSS | ❌ No | Commission only | GMV - Commission |
| 🇧🇷 Brazil | NET | ✅ Partial | Commission + Withholding taxes | GMV - all deductions |

* * * * *


## Key Takeaways for Implementation

1. GROSS vs NET mode determines how tax is displayed to the buyer but the payout logic depends on the tax agent role, not the price mode.
2. Domestic vs. foreign merchant is the biggest variable — most countries only require marketplace tax collection for foreign/non-resident sellers.
3. Your payout engine needs to support at least 3 deduction types: commission, VAT/GST withholding, and income/withholding tax (TDS-style).
4. Commission can be calculated on GROSS (incl. tax) or NET (excl. tax) — this is a business decision but has tax implications (VAT on commission).
5. Consider building a tax agent flag per merchant per country to toggle whether the marketplace withholds VAT or not.
