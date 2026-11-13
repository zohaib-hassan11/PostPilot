# UI design system (Social Hub)

One reusable component per job. Pages compose these; they never hand-style buttons, cards or tables.

| Component | Use for |
|---|---|
| `Button.vue` | Every button/link-button. Variants `primary secondary dark danger warning soft ghost`, sizes `xs sm md lg`, `href` → Inertia Link, `loading`, `block`. |
| `Card.vue` | Every surface/panel. Slots `title description action footer`, `padding`, `interactive`. |
| `PageHeader.vue` | Top of every page: `title`, `eyebrow`, slots `description actions`. |
| `Badge.vue` | Status pills (`success`, `warning`, `danger`, `primary`, `info`, `neutral`, `dark`, `dot`). |
| `EmptyState.vue` | "Nothing here yet" blocks with an action. |
| `StatCard.vue` | KPI tiles on dashboards. |
| `Table` | `DataDisplay/Table.vue` + `TableRow` + `TableCell` (restyled: bordered card, soft header, row hover). |
| `Alert.vue` | Inline info/success/warning/error with optional `title` and `actions` slot. |
| `FormField.vue` | Label + control + hint + `count/max` counter + error. Wrap every form control in it. |
| `TagInput.vue` | Chip-style tags (Enter/comma adds, Backspace removes, `max`). |
| Forms | `Form/Input`, `Textarea`, `Select` (restyled: rounded-lg, purple focus ring). |

Legacy Mixpost buttons (`PrimaryButton`, `SecondaryButton`, `DangerButton`, `WarningButton`, `DarkButtonLink`) and `Surface/Panel`
are thin wrappers around these, so old pages stay consistent. New code should import from `@/Components/UI/*` directly.
Colours: purple = Tailwind `indigo-*` (remapped in `css/app.css`), dark = `#0b0b10`.
