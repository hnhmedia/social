-- ========================================
-- Update Branding from Famoid to Genuine Socials
-- This will update all existing testimonials and FAQs
-- ========================================

-- Update testimonials - replace Famoid with Genuine Socials
UPDATE `si_testimonials` 
SET `content` = REPLACE(`content`, 'Famoid', 'Genuine Socials'),
    `content` = REPLACE(`content`, 'famoid', 'Genuine Socials'),
    `content` = REPLACE(`content`, 'FAMOID', 'Genuine Socials'),
    `title` = REPLACE(`title`, 'Famoid', 'Genuine Socials'),
    `title` = REPLACE(`title`, 'famoid', 'Genuine Socials'),
    `title` = REPLACE(`title`, 'FAMOID', 'Genuine Socials'),
    `updated_at` = NOW()
WHERE 
    `content` LIKE '%famoid%' 
    OR `content` LIKE '%Famoid%' 
    OR `content` LIKE '%FAMOID%'
    OR `title` LIKE '%famoid%' 
    OR `title` LIKE '%Famoid%' 
    OR `title` LIKE '%FAMOID%';

-- Update FAQs - replace Famoid with Genuine Socials  
UPDATE `si_faqs` 
SET `question` = REPLACE(`question`, 'Famoid', 'Genuine Socials'),
    `question` = REPLACE(`question`, 'famoid', 'Genuine Socials'),
    `question` = REPLACE(`question`, 'FAMOID', 'Genuine Socials'),
    `answer` = REPLACE(`answer`, 'Famoid', 'Genuine Socials'),
    `answer` = REPLACE(`answer`, 'famoid', 'Genuine Socials'),
    `answer` = REPLACE(`answer`, 'FAMOID', 'Genuine Socials'),
    `updated_at` = NOW()
WHERE 
    `question` LIKE '%famoid%' 
    OR `question` LIKE '%Famoid%' 
    OR `question` LIKE '%FAMOID%'
    OR `answer` LIKE '%famoid%' 
    OR `answer` LIKE '%Famoid%' 
    OR `answer` LIKE '%FAMOID%';

-- Show updated counts
SELECT 
    'Testimonials Updated' as status,
    COUNT(*) as count 
FROM `si_testimonials` 
WHERE `content` LIKE '%Genuine Socials%' OR `title` LIKE '%Genuine Socials%';

SELECT 
    'FAQs Updated' as status,
    COUNT(*) as count 
FROM `si_faqs` 
WHERE `question` LIKE '%Genuine Socials%' OR `answer` LIKE '%Genuine Socials%';

-- Verify no more mentions of Famoid remain
SELECT 
    'Remaining Famoid Mentions in Testimonials' as warning,
    COUNT(*) as count 
FROM `si_testimonials` 
WHERE `content` LIKE '%famoid%' OR `title` LIKE '%famoid%';

SELECT 
    'Remaining Famoid Mentions in FAQs' as warning,
    COUNT(*) as count 
FROM `si_faqs` 
WHERE `question` LIKE '%famoid%' OR `answer` LIKE '%famoid%';
