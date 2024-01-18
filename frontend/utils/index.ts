import type { SelectOptionItems } from '@/types/index';
import { useDateFormat, useToString } from '@vueuse/core';

export function handleInvalidForm(error: any): string
{

    let ret = '';

    if (error.status === 422)
    {

        if (error._data.errors)
        {

            let error_array = [];
            for (let key in error._data.errors)
            {

                error_array.push(error._data.errors[key]);

            }

            ret = error_array.join('<br>');

        }

        if (error._data.input_error)
        {

            let error_array = [];
            for (let key in error._data.input_error)
            {

                error_array.push(error._data.input_error[key]);

            }

            ret = error_array.join('<br>');

        }

        if (error._data.other_error)
        {

            ret = error._data.other_error;

        }

    }

    return ret;

}

export function arrangeAsSelectOptions(inData: Map<string, number | string>): SelectOptionItems
{

    const options: SelectOptionItems = [];

    if (inData.size > 0)
    {

        inData.forEach((value, key) =>
        {
            options.push(
            {
                key: key,
                value: value,
            });

        });

    }

    return options;

}

export function dateTimeFormat(dateTime: Date): ComputedRef<string>
{

    return useToString(useDateFormat(dateTime, 'YYYY年M月D日 H時m分'));

}

export function dateFormat(dateValue: Date): ComputedRef<string>
{

    return useToString(useDateFormat(dateValue, 'YYYY年M月D日'));

}

export function getPercentage(numerator: number, denominator: number): number | undefined
{

    if (numerator === 0 || denominator === 0)
    {

        return 0;

    }

    return Math.floor((numerator / denominator)*100);

}

export function eraseForm(): void
{

    if (document.getElementsByTagName('input').length > 0)
    {

        const input = document.getElementsByTagName('input');
        for (let i = 0; i < input.length; i++)
        {

            input[i].value = '';

        }

    }

}
