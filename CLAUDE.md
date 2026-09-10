# Kakoma SS Website — Project Brief

## Overview
Official website for Kakoma Secondary School (Rakai District, Uganda), built to launch
alongside the school's Diamond Jubilee (60th anniversary) on **14 November 2026**.
This is not a one-off anniversary microsite — it's meant to be a **living website** the
school keeps updating long after the Jubilee.

- **Domain:** kakomass.com (already reserved)
- **Deadline:** Live and fully functional before 14 November 2026
- **Motto:** "Labour for Success"
- **Built by:** Thirdsan Enterprises, alongside a parallel 60-page anniversary magazine
  (print + digital editions) — the digital magazine will be hosted on this site.

## Brand
- Primary colors: Navy blue + gold/yellow (from the school crest — confirm exact hex
  from the logo file provided)
- Crest/logo: provided in `/assets/logo/`
- Tone: proud, warm, rooted in history — not corporate

## Assets Provided
- `/assets/logo/` — school crest, various formats
- `/assets/photos/dinner/` — Old Students' fundraising dinner (15 Aug 2026)
- `/assets/photos/rakai/` — Rakai field trip interviews and location photos
- `/assets/photos/campus/` — current school campus (if available)
- Interview/testimony data collected via one-page intake forms at the dinner
  (name, class year, current role, quotes) — to be supplied as text/spreadsheet

### Photo Captioning Convention
Each photo folder (`dinner/`, `rakai/`, `campus/`) will include a `captions.csv` alongside
the images, with columns: `filename, caption, people, date, location`. Match photos to
their captions by filename before building any gallery or profile page — do not guess
at who's in a photo from the image alone.

## Sitemap — Phase 1 (must be live by 14 Nov)
1. **Home** — hero banner, "Kakoma at 60" headline, highlight strip, CTA to digital magazine
2. **Kakoma at 60** (Anniversary Hub) — countdown/date, dinner highlights + photos,
   60-years timeline, links to print/digital magazine
3. **Our History** — founding story, the Kingdom of Kooki land gift, founding families,
   the school's major eras
4. **Word From the Board** — message from Board Chair/members
5. **Head Teacher's Message** — note: current HM is an old student — worth foregrounding
   that "from student to headteacher" angle
6. **Old Students / Alumni** — profiles/testimonies from the dinner + Rakai trip, plus a
   simple self-registration form so the list keeps growing after launch
7. **Digital Magazine** — page-flip style reader embedding/linking the 60-page digital edition
8. **Gallery** — dinner, Rakai trip, campus, historical archive photos
9. **Blog / Recent Activities** — ongoing activity log; first post is the Old Students'
   fundraising dinner (15 Aug 2026), written up with photos and highlights
10. **Events** — upcoming school events; currently just the Diamond Jubilee itself,
    marked "Coming Soon" (14 Nov 2026) until further event details are confirmed
11. **Contact** — address, phone, email, socials, map

## Sitemap — Phase 2 (fast follow after launch)
12. **E-Learning — Coming Soon** — teaser only for now; short description tied to a
    future elibrary.africa integration, with an email/phone capture for interest
13. **Academics / Admissions** — programs offered, how to apply
14. **Give / Support** — donations/sponsorship, alumni acknowledgment page

## Site-Wide Requirements
- **Sitewide "60 Years" banner/ribbon** — persistent anniversary marker visible across
  all pages (not just the homepage hero), reinforcing the Jubilee throughout the site
- Simple admin/CMS access so non-technical staff can post updates without a rebuild
- Mobile-first — most alumni will open shared links on a phone
- Social share buttons on the magazine and anniversary pages
- Basic analytics (page views, especially on the digital magazine)
- Fast load on modest connections (target audience includes rural/low-bandwidth users)

## Open Questions for the Team
- Confirm exact crest hex colors from the logo file
- Confirm hosting target (Thirdsan's own infrastructure vs. third-party)
- Confirm CMS/tech stack preference before scaffolding begins
