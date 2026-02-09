# Database Migrations

This folder contains SQL migration files for database schema changes.

## How to Run Migrations

### Via Command Line (Recommended)

```bash
# Navigate to project root
cd C:\century\socialig\socialig

# Run a specific migration
mysql -u root -p social < database/migrations/2026_02_10_add_service_display_fields.sql
```

### Via Adminer/phpMyAdmin

1. Open Adminer at your database URL
2. Login with credentials from `config/database.php`
3. Select the `social` database
4. Click "SQL command"
5. Copy and paste the migration file contents
6. Click "Execute"

## Migration Files

| File | Description | Date |
|------|-------------|------|
| `2026_02_10_add_service_display_fields.sql` | Adds homepage display fields to si_services table | 2026-02-10 |

## Migration Naming Convention

Format: `YYYY_MM_DD_description.sql`

Example: `2026_02_10_add_service_display_fields.sql`

## Before Running Migrations

1. **Backup your database** (always!)
2. Review the migration SQL
3. Check for conflicts with existing data
4. Test on staging environment first (if available)

## After Running Migrations

1. Verify tables/columns were created
2. Check for any SQL errors
3. Test affected application features
4. Update documentation if needed

## Rollback

If a migration causes issues, you may need to manually rollback:

```sql
-- Example: Remove columns added by migration
ALTER TABLE si_services 
DROP COLUMN emoji,
DROP COLUMN subtitle,
DROP COLUMN badge,
DROP COLUMN badge_class,
DROP COLUMN features,
DROP COLUMN review_count,
DROP COLUMN avg_delivery,
DROP COLUMN show_on_homepage,
DROP COLUMN homepage_order;

-- Remove index
ALTER TABLE si_services DROP INDEX idx_homepage_display;
```

**Note:** Always backup before rollback!
