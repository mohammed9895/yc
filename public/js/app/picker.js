import { easepick, LockPlugin } from "../../node_modules/@easepick/bundle";
import style from '../../node_modules/@easepick/bundle/dist/index.css?url'
import easepickVariables from '../../resources/css/easepickVariables.css?url'
import pluralize from '../../node_modules/pluralize'

export default function (Alpine) {
    Alpine.directive('picker', (el, { expression }, { evaluate }) => {
        const options = evaluate(expression)

        const picker = new easepick.create({
            element: el,
            readonly: true,
            zIndex: 50,
            date: options.date,
            css: [
                style,
                easepickVariables
            ],
            plugins: [
                LockPlugin
            ],
            LockPlugin: {
                minDate: new Date(),
                filter (date) {
                    return !options.availability.find(a => a.date === date.format('YYYY-MM-DD'))
                }
            },
            setup (picker) {
                picker.on('view', (e) => {
                    const { view, date, target } = e.detail

                    const dateString = date ? date.format('YYYY-MM-DD') : null

                    const availability = options.availability.find(a => a.date === dateString)

                    if (view === 'CalendarDay' && availability) {
                        const span = target.querySelector('.day-slots') || document.createElement('span')

                        span.className = 'day-slots'
                        span.innerHTML = pluralize('slot', Object.keys(availability.slots).length, true)

                        target.append(span)
                    }
                })
            }
        })

        picker.on('select', (e) => {
            el.dispatchEvent(
                new CustomEvent('select', { detail: e.detail.date.format('YYYY-MM-DD') })
            )
        })
    })
}
