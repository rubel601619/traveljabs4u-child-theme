<?php

/**
 * @param this file is only for store page schema
 */

add_filter( 'rank_math/json_ld', function( $data, $jsonld ) {

    if ( ! is_front_page() ) {
        return $data;
    }

    return [];

}, 99, 2 );


add_action( 'wp_head', function () {

    if ( ! is_front_page() ) {
        return;
    }
    ?>
        <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@graph": [
            {
            "@type": "Organization",
            "@id": "https://traveljabs4u.co.uk/#organization",
            "name": "TravelJabs4U",
            "url": "https://traveljabs4u.co.uk/",
            "logo": {
                "@type": "ImageObject",
                "@id": "https://traveljabs4u.co.uk/#logo",
                "url": "https://traveljabs4u.co.uk/wp-content/uploads/2025/03/traveljabs4u-logo.png.webp",
                "contentUrl": "https://traveljabs4u.co.uk/wp-content/uploads/2025/03/traveljabs4u-logo.png.webp",
                "width": 1000,
                "height": 250,
                "caption": "TravelJabs4U"
            },
            "image": { "@id": "https://traveljabs4u.co.uk/#logo" },
            "email": "info@traveljabs4u.co.uk",
            "telephone": "+441604345869",
            "sameAs": [
                "REPLACE_WITH_REAL_TRUSTPILOT_URL",
                "REPLACE_WITH_REAL_FACEBOOK_URL"
            ],
            "contactPoint": [
                {
                "@type": "ContactPoint",
                "contactType": "customer service",
                "telephone": "+441604345869",
                "email": "info@traveljabs4u.co.uk",
                "areaServed": { "@type": "Country", "name": "United Kingdom" },
                "availableLanguage": ["English"]
                }
            ]
            },
            {
            "@type": "WebSite",
            "@id": "https://traveljabs4u.co.uk/#website",
            "url": "https://traveljabs4u.co.uk/",
            "name": "TravelJabs4U",
            "publisher": { "@id": "https://traveljabs4u.co.uk/#organization" },
            "inLanguage": "en-GB"
            },
            {
            "@type": "WebPage",
            "@id": "https://traveljabs4u.co.uk/#webpage",
            "url": "https://traveljabs4u.co.uk/",
            "name": "UK Travel Vaccination Clinics | TravelJabs4U",
            "description": "Find trusted travel vaccination clinics across the UK. Check vaccines by destination, view prices and book a travel health appointment near you.",
            "isPartOf": { "@id": "https://traveljabs4u.co.uk/#website" },
            "about": { "@id": "https://traveljabs4u.co.uk/#organization" },
            "publisher": { "@id": "https://traveljabs4u.co.uk/#organization" },
            "inLanguage": "en-GB"
            },
            {
            "@type": "FAQPage",
            "@id": "https://traveljabs4u.co.uk/#faq",
            "isPartOf": { "@id": "https://traveljabs4u.co.uk/#webpage" },
            "mainEntity": [
                {
                "@type": "Question",
                "name": "When should I get my travel vaccinations?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Try to seek travel-health advice at least four to six weeks before departure. Some vaccines require several doses or need time to provide protection. If you are travelling sooner, contact a travel-health professional because useful advice, vaccination or other preventive measures may still be available."
                }
                },
                {
                "@type": "Question",
                "name": "How much do travel vaccinations cost in the UK?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Prices vary by vaccine and clinic. Some vaccines are available free on the NHS, while others are private and charged per dose. You can compare prices using the TravelJabs4U travel vaccination price guide before you book."
                }
                },
                {
                "@type": "Question",
                "name": "Which travel vaccines do I need?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "It depends on your destination, the length and type of your trip, and your medical history. Check the relevant destination page for the vaccines that may be recommended or required, then confirm with a travel-health professional."
                }
                },
                {
                "@type": "Question",
                "name": "Which travel vaccines are free on the NHS?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Some travel vaccines are usually free on the NHS, including hepatitis A, typhoid, cholera, and polio (given as part of the combined tetanus, diphtheria and polio vaccine). Others, such as yellow fever, rabies, hepatitis B and Japanese encephalitis, are normally private and charged for."
                }
                },
                {
                "@type": "Question",
                "name": "Do I need malaria tablets?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Not every traveller needs antimalarial tablets. The need depends on the regions you are visiting, your itinerary and your health history, so it is assessed during a travel-health consultation alongside advice on avoiding mosquito bites."
                }
                },
                {
                "@type": "Question",
                "name": "How long do travel vaccinations last?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "It depends on the vaccine. Some provide protection for a year or two, others for ten years or longer, and a few require booster doses. Your clinic can confirm how long your vaccines last and whether a booster is due."
                }
                },
                {
                "@type": "Question",
                "name": "Where can I get travel jabs near me?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Use the TravelJabs4U clinic finder to locate trusted travel vaccination clinics across the UK, check the vaccines they offer and book an appointment."
                }
                }
            ]
            }
        ]
        }
        </script>

    <?php

}, 100 );