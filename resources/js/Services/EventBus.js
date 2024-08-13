import { ref } from 'vue';

const eventBus = ref(new Map());

export function emit(event, payload) {
  eventBus.value.get(event)?.forEach(fn => fn(payload));
}

export function on(event, handler) {
  if (!eventBus.value.has(event)) {
    eventBus.value.set(event, []);
  }
  eventBus.value.get(event).push(handler);
}

export function off(event, handler) {
  const handlers = eventBus.value.get(event);
  if (handlers) {
    eventBus.value.set(event, handlers.filter(h => h !== handler));
  }
}