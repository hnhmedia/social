# Genuine Socials Redesign Checklist

## Phase 1 – Foundation & Cleanup
- [x] Rebrand copy (site/admin/auth) to Genuine Socials
- [x] Normalize design tokens (brand.css) and remove legacy styling bleed
- [x] Fix order widget layout consistency (package grid, inner wrapper)
- [x] Docker dev stack up to date and rebuilds cleanly
- [ ] Verify all service pages grids after branding sweep (spot-check non-IG pages)
- [ ] Fill in real local secrets in .env (copy from .env.example)

## Phase 2 – UX Polish & Content
- [ ] Refine hero/CTA copy and add trust microcopy where thin
- [ ] Tighten spacing/typography tokens and document preferred heading/body sizes
- [ ] Add/refresh illustrative assets (icons/avatars) to match brand
- [ ] QA responsive states (mobile/tablet) for order flow and nav

## Phase 3 – Integrations & Flows
- [ ] End-to-end order flow smoke (cart → checkout → callbacks)
- [ ] Email templates: rebrand and test SMTP send
- [ ] Payment gateway config and test mode validation
- [ ] Error states/loading skeletons for service pages

## Phase 4 – Admin & Data Hygiene
- [ ] Admin branding and navigation polish
- [ ] Seed data review: packages, FAQs, testimonials alignment
- [ ] Access control/login flows retest after branding

## Phase 5 – Launch Readiness
- [ ] Content proof (grammar/consistency) across pages
- [ ] Performance pass (asset minify/cache headers) in Docker image
- [ ] Final cross-browser/mobile sweep
- [ ] Go-live checklist (env vars, backups, monitoring)
