import { InertiaLinkProps } from '@inertiajs/vue3';
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
};

export function debounce(callback: Function, delay: number = 1000) {
    let timeoutId = 0;
    return (...args: any[]) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => callback(...args), delay);
    };
};

export function urlIsActive(
    urlToCheck: NonNullable<InertiaLinkProps['href']>,
    currentUrl: string,
) {
    return toUrl(urlToCheck) === currentUrl;
};

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
};

export function randomString(length: number = 8, alphabet: string = 'abcdefghijklmnopqrstuvwxyz'): string {
    let value = '';

    while (value.length < length) {
        value += alphabet[Math.floor(Math.random() * alphabet.length)];
    }

    return value;
};

export function slugify(str: string): string {
    let value = str.toLowerCase();

    value = value.replace(/\W/g, '-');
    value = value.replace(/-{2,}/g, '-');

    if (value.substring(0, 1) === '-') value =  value.substring(1);
    if (value.substring(value.length - 1) === '-') value = value.substring(0, value.length - 1);

    return value;
};
